<?php
if (!isset($_SESSION)) {
    session_start();
}

const TITLE = 'Course';
const PAGE = 'view-course';
const DIRECTORY = '../';

include('../dbConnection.php');

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit();
}

// Fetch course details, lessons, and quizzes
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $student_email = $_SESSION['student_email']; // Student email from session
    $student_id = $_SESSION['student_id']; // Student ID from session
    $course_desc = '';
    $lessons = [];
    $quizzes = [];

    // Check if the course was bought more than 2 months ago**
    $order_sql = "SELECT order_date FROM courseorder WHERE course_id = ? AND stu_email = ?";
    $stmt = $conn->prepare($order_sql);
    $stmt->bind_param("is", $course_id, $student_email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $order_row = $result->fetch_assoc();
        $order_date = strtotime($order_row['order_date']);
        $two_months_ago = strtotime("-2 months");

        // If course was purchased more than 2 months ago, delete it
        if ($order_date < $two_months_ago) {
            $delete_sql = "DELETE FROM courseorder WHERE course_id = ? AND stu_email = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("is", $course_id, $student_email);
            $stmt->execute();
            $stmt->close();

            // Show alert and redirect
            echo "<script>
                alert('Your course has expired. Please purchase again.');
                window.location.href = 'my-courses.php';
            </script>";
            exit();
        }
    }
    $stmt->close();

    // Fetch course description
    $course_sql = "SELECT * FROM course WHERE course_id = '$course_id'";
    $course_result = $conn->query($course_sql);
    if ($course_result->num_rows > 0) {
        $course_row = $course_result->fetch_assoc();
        $course_desc = $course_row['course_desc'];
        $course_name = $course_row['course_name'];
    }

    // Fetch lessons for the course
    $lessons_sql = "SELECT * FROM lesson WHERE course_id = '$course_id'";
    $lessons_result = $conn->query($lessons_sql);
    if ($lessons_result->num_rows > 0) {
        while ($lesson_row = $lessons_result->fetch_assoc()) {
            $lessons[] = $lesson_row;
        }
    }

    // Fetch quizzes for the course and their submission status
    $quizzes_sql = "SELECT * FROM quiz WHERE course_id = '$course_id'";
    $quizzes_result = $conn->query($quizzes_sql);
    if ($quizzes_result->num_rows > 0) {
        while ($quiz_row = $quizzes_result->fetch_assoc()) {
            // Check if the student has submitted the quiz
            $quiz_id = $quiz_row['id'];
            $submission_sql = "SELECT * FROM quiz_files WHERE quiz_id = '$quiz_id' AND student_id = '$student_id'";
            $submission_result = $conn->query($submission_sql);
            $submission_status = $submission_result->num_rows > 0 ? 'Submitted' : 'Pending';
            $quiz_row['submission_status'] = $submission_status;
            $quizzes[] = $quiz_row;
        }
    }
}

include 'include/sidebar.php'; // Include the sidebar (HTML, head, body tags, etc.)
?>

<div class="container mx-auto mt-5">
    <!-- Course Header -->
    <div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
        <h3 class="text-center text-white">Lessons and Quizzes for</h3>
        <h3 class="text-center text-4xl font-extrabold my-2"><?= isset($course_name) ? $course_name : "" ?></h3>
    </div>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Course Description -->
            <div class="col-sm-12 mb-4">
                <div class="bg-white shadow-lg rounded-lg p-4">
                <p class="text-center text-lg text-gray-950 text-bold mb-2">Course Description:</p>
                    <?php if (isset($course_desc)) echo '<p>' . $course_desc . '</p>'; ?>
                </div>
            </div>

            
            <!-- Lessons List -->
            <div class="my-4">
                <h4 class="text-2xl font-semibold text-violet-600 mb-4">Lessons</h4>
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr>
                                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">SL NO.</th>
                                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Lesson Title</th>
                                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lessons as $index => $lesson): ?>
                            <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                                <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
                                <td class="py-4 px-4 text-sm"><?= htmlspecialchars($lesson['lesson_name']) ?></td>
                                <td class="py-4 px-4 text-sm">
                                    <a href="view-lesson.php?lesson_id=<?= $lesson['lesson_id'] ?>&course_id=<?= $course_id ?>" class="text-violet-600 hover:underline">View Lesson</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quizzes List -->
<div class="my-4">
    <h4 class="text-2xl font-semibold text-violet-600 mb-4">Quizzes</h4>
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">SL NO.</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Description</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quizzes as $index => $quiz): ?>
                <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                    <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars(substr($quiz['description'], 0, 80) . '...') ?></td>
                    <td class="py-4 px-4 text-sm">
                        <a href="view-quiz.php?quiz_id=<?= $quiz['id'] ?>&course_id=<?= $course_id ?>" class="text-violet-600 hover:underline">View Quiz</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

        </div>
    </div>
</div>

<?php include '../mainInclude/footer.php'; // Include the footer ?>
