<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Check if the instructor is logged in
if (!isset($_SESSION['instructor_id'])) {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

$courses = [];
$instructor_id = $_SESSION['instructor_id'];

// Handle course deletion
if (isset($_POST['deleteCourse']) && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
    
    // Use a prepared statement to delete the course
    $deleteStmt = $conn->prepare("DELETE FROM course WHERE course_id = ? AND instructor_id = ?");
    $deleteStmt->bind_param("ii", $course_id, $instructor_id);
    if ($deleteStmt->execute()) {
        $deleteMsg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Course deleted successfully!</div>';
        $success_message = "Course deleted successfully!";
    } else {
        $deleteMsg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to delete course. Please try again later.</div>';
        $error_message = "Failed to delete course!";
    }
    $deleteStmt->close();
}

// Fetch all courses for this instructor
$stmt = $conn->prepare("SELECT * FROM course WHERE instructor_id = ?");
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}
$stmt->close();

const TITLE = 'Courses';
const PAGE = 'courses';

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Courses</h3>
    <p class="text-center text-lg text-gray-600 mb-2">This is the list of all the courses you have created.</p>
</div>

<!-- Display Delete Message -->
<?php if (isset($deleteMsg)) { echo $deleteMsg; } ?>

<div class="flex justify-end my-2">
    <a href="add-course.php" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded-full shadow-lg flex items-center justify-center">
        <i class="fas fa-plus fa-lg mr-2"></i> Add Course
    </a>
</div>

<div class="flex justify-center">
    <div class="w-full bg-white shadow-lg rounded-lg overflow-auto">
        <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
            <thead>
            <tr>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">SL NO.</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Name</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Duration</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Price</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Action</th>
            </tr>
            </thead>
            <tbody>

            <!-- If table is empty -->
            <?php if (empty($courses)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4">No courses found</td>
                </tr>
            <?php endif; ?>

            <!-- PHP loop -->
            <?php
            foreach ($courses as $index => $course):
            ?>
                <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                    <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($course["course_name"]) ?></td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($course["course_duration"]) ?> Days</td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($course["course_price"]) ?> TK</td>
                    <td class="py-4 px-4 text-sm relative">
                        <button onclick="toggleDropdown(event, 'dropdown<?= $index + 1 ?>')" class="text-violet-600 px-4 py-2 rounded border transition duration-150 ease-in-out">Action</button>
                        <div id="dropdown<?= $index + 1 ?>" class="hidden dropdown-content absolute bg-white z-10 shadow-md rounded mt-2 w-24">
                            <a href="<?= 'view-course.php?course_id=' . $course['course_id'] ?>" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">View</a>
                            <a href="<?= 'edit-course.php?course_id=' . $course['course_id'] ?>" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">Edit</a>
                            <!-- Delete functionality -->
                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');" class="block w-full">
                                <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
                                <button type="submit" name="deleteCourse" class="w-full px-4 py-2 text-left text-violet-800 hover:bg-violet-200">Delete</button>
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

<?php
include('../mainInclude/footer.php');
?>
