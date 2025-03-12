<?php
session_start();
const TITLE = 'My Course';
const PAGE = 'mycourse';
const DIRECTORY = '../';

include_once('../dbConnection.php');

if (!isset($_SESSION['student_id'])) {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

$student_id = $_SESSION['student_id'];
$student = null;
$ordered_courses = [];
$avg_ratings = [];
$my_ratings = [];

// Fetch student details
$stmt = $conn->prepare("SELECT * FROM student WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
}
$stmt->close();

// Fetch ordered courses with order date
if ($student) {
    $email = $student["email"];
    $stmt = $conn->prepare("
        SELECT co.course_id, co.order_date, c.*
        FROM courseorder AS co
        JOIN course AS c ON c.course_id = co.course_id
        WHERE co.stu_email = ? AND co.status = 'TXN_SUCCESS'
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $ordered_courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if (!empty($ordered_courses)) {
        $course_ids = array_column($ordered_courses, 'course_id');
        $placeholders = implode(',', array_fill(0, count($course_ids), '?'));

        $stmt = $conn->prepare("
            SELECT course_id, AVG(rating) AS avg_rating, 
                   MAX(CASE WHEN student_id = ? THEN rating ELSE NULL END) AS my_rating
            FROM course_rating
            WHERE course_id IN ($placeholders)
            GROUP BY course_id
        ");
        $params = array_merge([$student_id], $course_ids);
        $stmt->bind_param(str_repeat('i', count($params)), ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $avg_ratings[$row['course_id']] = round($row['avg_rating'], 1);
            $my_ratings[$row['course_id']] = $row['my_rating'];
        }
        $stmt->close();
    }
}

include('./include/sidebar.php');
?>

<div class="container mx-auto mt-5">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h4 class="text-center text-2xl font-semibold mb-4">My Courses</h4>

        <?php if (empty($ordered_courses)): ?>
            <p class="text-center text-gray-600">No courses found.</p>
        <?php endif; ?>

        <?php foreach ($ordered_courses as $course): ?>
            <?php
            $course_id = $course['course_id'];
            $avg_rating = $avg_ratings[$course_id] ?? 0;
            $my_rating = $my_ratings[$course_id] ?? 0;
            
            // Calculate remaining time
            $order_date = strtotime($course['order_date']);
            $current_time = time();
            $course_duration = 60 * 24 * 60 * 60; // 60 days in seconds
            $expiry_time = $order_date + $course_duration;
            $days_left = ceil(($expiry_time - $current_time) / (24 * 60 * 60));

            $remaining_text = ($days_left > 0) ? "$days_left days left" : "Expired";
            $remaining_class = ($days_left > 0) ? "text-green-500" : "text-red-500";
            ?>
            
            <div class="bg-violet-100 mb-6 p-6 rounded-lg shadow-md flex flex-col h-full">
                <div class="flex justify-between items-center">
                    <h5 class="text-xl font-bold text-violet-700"><?= $course['course_name']; ?></h5>
                    <div class="text-yellow-500 flex items-center">
                        <span class="text-lg font-bold mr-1"><?= $avg_rating; ?></span>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center mt-4">
                    <div class="lg:col-span-1 h-48">
                        <img src="<?= $course['course_img']; ?>" class="rounded-lg w-full h-full object-cover" alt="Course Image">
                    </div>

                    <div class="lg:col-span-2 flex flex-col justify-between h-full">
                        <p class="text-violet-600 mb-2">Duration: <?= $course['course_duration']; ?></p>
                        <p class="text-violet-600 mb-2">Instructor: <?= $course['course_author']; ?></p>
                        <p class="text-violet-600 mb-2">Price: 
                            <span class="font-bold">&#2547;<?= $course['course_price']; ?></span>
                        </p>

                        <p class="text-violet-600 mb-2 font-bold">
                            Time Left: <span class="<?= $remaining_class; ?>"><?= $remaining_text; ?></span>
                        </p>

                        <div class="flex items-center mb-2">
                            <div class="mr-4">
                                <p class="text-violet-600">Course Rating:</p>
                                <div class="text-yellow-500">
                                    <span class="font-bold"><?= $avg_rating; ?></span> 
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star<?= $i < $avg_rating ? '' : '-o'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div>
                                <p class="text-violet-600">My Rating:</p>
                                <div class="text-yellow-500 flex items-center">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star<?= $i < $my_rating ? '' : '-o'; ?>" onclick="openRatingModal(<?= $course_id ?>, <?= $my_rating ?>)"></i>
                                    <?php endfor; ?>
                                    <span class="ml-2 cursor-pointer text-blue-500" onclick="openRatingModal(<?= $course_id ?>, <?= $my_rating ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </span>
                                </div>
                            </div>
                        </div>

                        <a href="view-course.php?course_id=<?= $course_id; ?>" class="inline-block mt-4 bg-violet-500 text-white py-2 px-6 rounded-lg w-36">
                            View Course
                        </a>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('../mainInclude/footer.php'); ?>
