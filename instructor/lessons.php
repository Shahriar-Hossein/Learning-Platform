<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Check session validity
// if (!isset($_SESSION['is_admin_login'])) {
//     echo "<script> location.href='../index.php'; </script>";
//     exit();
// }

// Securely retrieve the instructor ID from the session
$instructor_id = $_SESSION['instructor_id'];

// Initialize the lessons array
$lessons = [];

// Prepare a query to fetch lessons for courses created by the instructor
$sql = "
    SELECT lesson.* 
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
                            <a href="#" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">Edit</a>
                            <a href="#" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../mainInclude/footer.php'); ?>


