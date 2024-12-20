<?php
session_start();
const TITLE = 'My Course';
const PAGE = 'mycourse';
const DIRECTORY = '../';

include_once('../dbConnection.php');

// Redirect if student session is not set
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

// Fetch ordered courses
if ($student) {
    $email = $student["email"];
    $stmt = $conn->prepare("
        SELECT co.order_id, c.course_id, c.course_name, c.course_duration, c.course_desc, c.course_img, c.course_author, c.course_original_price, c.course_price
        FROM courseorder AS co
        JOIN course AS c ON c.course_id = co.course_id
        WHERE co.stu_email = ?
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $ordered_courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if (!empty($ordered_courses)) {
        $course_ids = array_column($ordered_courses, 'course_id');
        $course_ids_placeholder = implode(',', array_fill(0, count($course_ids), '?'));

        // Fetch average and individual ratings in a single query
        $stmt = $conn->prepare("
            SELECT course_id, AVG(rating) AS avg_rating, 
                   MAX(CASE WHEN student_id = ? THEN rating ELSE NULL END) AS my_rating
            FROM course_rating
            WHERE course_id IN ($course_ids_placeholder)
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
            ?>
            <div class="bg-violet-100 mb-6 p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center">
                    <h5 class="text-xl font-bold text-violet-700"><?= $course['course_name']; ?></h5>
                    <div class="text-yellow-500 flex items-center">
                        <span class="text-lg font-bold mr-1"><?= $avg_rating; ?></span>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center mt-4">
                    <!-- Course Image -->
                    <div class="lg:col-span-1">
                        <img src="<?= $course['course_img']; ?>" class="rounded-lg w-full h-auto" alt="Course Image">
                    </div>

                    <!-- Course Details -->
                    <div class="lg:col-span-2">
                        <p class="text-violet-600 mb-2">Duration: <?= $course['course_duration']; ?></p>
                        <p class="text-violet-600 mb-2">Instructor: <?= $course['course_author']; ?></p>
                        <p class="text-violet-600 mb-2">
                            Price: 
                            <span class="line-through text-gray-500">&#2547;<?= $course['course_original_price']; ?></span> 
                            <span class="font-bold">&#2547;<?= $course['course_price']; ?></span>
                        </p>

                        <!-- Display Course Rating and My Rating -->
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
                                        <i class="fas fa-star<?= $i < $my_rating ? '' : '-o'; ?>" id="my-rating-<?= $course_id . '-' . $i ?>" onclick="openRatingModal(<?= $course_id ?>, <?= $my_rating ?>)"></i>
                                    <?php endfor; ?>
                                    <span class="ml-2 cursor-pointer text-blue-500" onclick="openRatingModal(<?= $course_id ?>, <?= $my_rating ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </span>
                                </div>
                            </div>
                        </div>

                        <a href="watchcourse.php?course_id=<?= $course_id; ?>" class="inline-block mt-4 bg-violet-500 text-white py-2 px-6 rounded-lg">
                            Watch Course
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="ratingModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-semibold text-violet-700 mb-4">Rate the Course</h3>
        <div id="ratingStars" class="text-yellow-500 mb-4">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="fas fa-star cursor-pointer" id="star-<?= $i; ?>" onclick="setRating(<?= $i; ?>)"></i>
            <?php endfor; ?>
        </div>
        <textarea id="ratingReview" class="w-full border rounded-lg p-2 mb-4" rows="4" placeholder="Write a review (optional)"></textarea>
        <div class="flex justify-end">
            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2" onclick="closeRatingModal()">Cancel</button>
            <button class="bg-violet-500 text-white px-4 py-2 rounded-lg hover:bg-violet-600" onclick="submitRating()">Submit</button>
        </div>
    </div>
</div>

<script>
    let currentRating = 0;
    let currentCourseId = 0;
    function openRatingModal(courseId, myRating) {
        currentRating = myRating;
        currentCourseId = courseId
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`star-${i}`);
            star.classList.toggle('fas', i <= myRating);
            star.classList.toggle('far', i > myRating);
        }
        document.getElementById('ratingModal').classList.remove('hidden');
    }

    function closeRatingModal() {
        document.getElementById('ratingModal').classList.add('hidden');
    }

    function setRating(rating) {
        currentRating = rating;
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`star-${i}`);
            star.classList.toggle('fas', i <= rating);
            star.classList.toggle('far', i > rating);
        }
    }

    function submitRating() {
        const review = document.getElementById('ratingReview').value;
        const data = { course_id: currentCourseId, rating: currentRating, review: review };

        fetch('submit-rating.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message || 'Rating submitted successfully!');
            closeRatingModal();
            location.reload(); // Refresh to show updated rating
        })
        .catch(error => console.error('Error:', error));
    }
</script>

<?php include('../mainInclude/footer.php'); ?>
