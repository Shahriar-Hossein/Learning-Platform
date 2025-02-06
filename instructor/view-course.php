<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Get course_id from the URL parameter
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Fetch course details (name and description)
    $stmt = $conn->prepare("SELECT * FROM course WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $course_result = $stmt->get_result();
    $course = $course_result->fetch_assoc();
    $course_name = $course['course_name'];
    $course_description = $course['course_desc'];

    // Fetch lessons for this course
    $lessons = [];
    $stmt = $conn->prepare("SELECT * FROM lesson WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $lesson_result = $stmt->get_result();
    while ($lesson = $lesson_result->fetch_assoc()) {
        $lessons[] = $lesson;
    }

    // Fetch quizzes for this course
    $quizzes = [];
    $stmt = $conn->prepare("SELECT * FROM quiz WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $quiz_result = $stmt->get_result();
    while ($quiz = $quiz_result->fetch_assoc()) {
        $quizzes[] = $quiz;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}

const TITLE = 'View Course';
const PAGE = 'courses';

include('include/sidebar.php');
?>

<!-- Course Header -->
<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h2 class="text-center text-4xl font-extrabold my-2"><?= htmlspecialchars($course_name) ?></h2>
</div>

<!-- Course Description -->
<div class="my-4 py-8 bg-violet-50 text-white shadow-lg rounded-lg">
    <p class="text-center text-lg text-gray-950 text-bold mb-2">Course Description:</p>
    <p class="text-center text-lg text-gray-600 text-bold mb-2"><?= htmlspecialchars($course_description) ?></p>
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
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Quiz Title</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quizzes as $index => $quiz): ?>
                <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                    <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($quiz['title']?? "quiz title") ?></td>
                    <td class="py-4 px-4 text-sm">
                        <a href="view-quiz.php?quiz_id=<?= $quiz['id'] ?>&course_id=<?= $course_id ?>" class="text-violet-600 hover:underline">View Quiz</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../mainInclude/footer.php'); ?>
