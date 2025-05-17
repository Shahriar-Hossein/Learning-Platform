<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Securely retrieve the instructor ID from the session
$instructor_id = $_SESSION['instructor_id'];

// Initialize the lessons array
$lessons = [];

// Handle lesson deletion
if (isset($_POST['deleteLesson']) && isset($_POST['lesson_id'])) {
    $lesson_id = $_POST['lesson_id'];

    // Prepare a statement to delete the lesson
    $deleteStmt = $conn->prepare("DELETE FROM lesson WHERE lesson_id = ? AND course_id IN (SELECT course_id FROM course WHERE instructor_id = ?)");
    $deleteStmt->bind_param("ii", $lesson_id, $instructor_id);

    if ($deleteStmt->execute()) {
        // Success message
        $deleteMsg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Lesson deleted successfully!</div>';
        $success_message = "Lesson deleted successfully!";
    } else {
        // Error message
        $deleteMsg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to delete lesson. Please try again later.</div>';
        $error_message = "Failed to delete lesson!";
    }
    $deleteStmt->close();
}

// Prepare the query to fetch lessons for courses created by the instructor
$sql = "
    SELECT lesson.*, course.* 
    FROM lesson
    INNER JOIN course ON lesson.course_id = course.course_id
    WHERE course.instructor_id = ?
";

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $instructor_id);

// Execute the statement
$stmt->execute();

// Fetch the results securely
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lessons[] = $row;
    }
}

// Close the statement
$stmt->close();

const TITLE = 'Lessons';
const PAGE = 'lessons';

include('include/sidebar.php');
?>
<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Lessons</h3>
    <p class="text-center text-lg text-gray-600 mb-2">This is the list of all the lessons you have created.</p>
</div>

<!-- Display Delete Message -->
<?php if (isset($deleteMsg)) { echo $deleteMsg; } ?>

<div class="flex justify-end my-2">
    <a href="add-lesson.php" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded-full shadow-lg flex items-center justify-center">
        <i class="fas fa-plus fa-lg mr-2"></i> Add Lesson
    </a>
</div>

<div class="flex justify-center">
    <div class="w-full bg-white shadow-lg rounded-lg overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">SL NO.</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Name</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Lesson Name</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($lessons as $index => $lesson): ?>
                <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                    <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($lesson["course_name"]) ?></td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($lesson["lesson_name"]) ?></td>
                    <td class="py-4 px-4 text-sm relative">
                        <button onclick="toggleDropdown(event, 'dropdown<?= $index + 1 ?>')" class="text-violet-600 px-4 py-2 rounded border transition duration-150 ease-in-out">Action</button>
                        <div id="dropdown<?= $index + 1 ?>" class="hidden dropdown-content absolute bg-white z-10 shadow-md rounded mt-2 w-24">
                        <a href="<?= 'view-lesson.php?lesson_id=' . $lesson['lesson_id'] . '&course_id=' . $lesson['course_id'] ?>"  class="block px-4 py-2 text-violet-800 hover:bg-violet-200">View</a>
                        <a href="<?= 'edit-lesson.php?lesson_id=' . $lesson['lesson_id'] ?>" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">Edit</a>
                        <!-- Delete Form -->
                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this lesson?');" class="block w-full">
                                <input type="hidden" name="lesson_id" value="<?= $lesson['lesson_id'] ?>">
                                <button type="submit" name="deleteLesson" class="w-full px-4 py-2 text-left text-violet-800 hover:bg-violet-200">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const notyf = new Notyf({ position: { x: 'right', y: 'top' }, duration: 4000 });

    <?php if (isset($success_message)): ?>
        notyf.success('<?= htmlspecialchars($success_message) ?>');
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        notyf.error('<?= htmlspecialchars($error_message) ?>');
    <?php endif; ?>
</script>

<?php include('../mainInclude/footer.php'); ?>
