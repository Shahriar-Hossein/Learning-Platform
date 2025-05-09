<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Get lesson_id and course_id from the URL parameters
if (isset($_GET['lesson_id']) && isset($_GET['course_id'])) {
    $lesson_id = $_GET['lesson_id'];
    $course_id = $_GET['course_id'];

    // Fetch lesson details (name, description, etc.)
    $stmt = $conn->prepare("SELECT * FROM lesson WHERE lesson_id = ? AND course_id = ?");
    $stmt->bind_param("ii", $lesson_id, $course_id);
    $stmt->execute();
    $lesson_result = $stmt->get_result();
    $lesson = $lesson_result->fetch_assoc();
    $lesson_name = $lesson['lesson_name'];
    $lesson_description = $lesson['lesson_desc'];
    $lesson_file = $lesson['lesson_link']; // Assuming the lesson contains a file link

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}

const TITLE = 'View Lesson';
const PAGE = 'courses';

include('include/sidebar.php');
?>

<!-- Lesson Header -->
<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h2 class="text-center text-4xl font-extrabold my-2"><?= htmlspecialchars($lesson_name) ?></h2>
</div>

<!-- Lesson Description -->
<div class="my-4 py-8 bg-violet-50 text-white shadow-lg rounded-lg">
    <p class="text-center text-lg text-gray-950 text-bold mb-2">Lesson Description:</p>
    <p class="text-center text-lg text-gray-600 text-bold mb-2"><?= htmlspecialchars($lesson_description) ?></p>
</div>

<!-- Lesson Material / File -->
<?php if (!empty($lesson_file)): ?>
<div class="my-4 py-8 bg-violet-50 text-white shadow-lg rounded-lg">
    <p class="text-center text-lg text-gray-950 text-bold mb-2">Lesson Material:</p>
    <?php if ($lesson['lesson_link']): ?>
        <div class="mt-2 max-w-2xl mx-auto">
            <video controls class="w-full h-96 object-contain">
                <source src="<?= htmlspecialchars($lesson['lesson_link']) ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="my-4 py-8 bg-violet-50 text-white shadow-lg rounded-lg">
    <p class="text-center text-lg text-gray-600">No materials available for this lesson.</p>
</div>
<?php endif; ?>

<!-- Back Button to Course -->
<div class="my-4 text-center">
    <a href="view-course.php?course_id=<?= $course_id ?>" class="bg-violet-600 hover:bg-violet-700 t
