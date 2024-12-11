<?php
if(!isset($_SESSION)){
    session_start();
}
include('../dbConnection.php');

//if(isset($_SESSION['is_admin_login'])){
//    $adminEmail = $_SESSION['adminLogEmail'];
//} else {
//    echo "<script> location.href='../index.php'; </script>";
//}

// Fetch all courses for this instructor.
$courses = [];
$instructor_id = $_SESSION['instructor_id'];

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM course WHERE instructor_id = ?");
$stmt->bind_param("i", $instructor_id);
$stmt->execute();

// Fetch results securely
$result = $stmt->get_result();
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $courses[] = $row;
    }
}
// Close the statement
$stmt->close();

const TITLE = 'Courses';
const PAGE = 'courses';

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Courses</h3>
    <p class="text-center text-lg text-gray-600 mb-2">This is the list of all the courses you have created.</p>
</div>

<!--        <button onclick="toggleSidebar()" class="lg:hidden bg-blue-500 text-white px-4 py-2 rounded mb-4">Toggle Sidebar</button>-->

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
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Original Price</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Price</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Action</th>
            </tr>
            </thead>
            <tbody>

            <!--                If table is empty    -->
            <?php if (empty($courses)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4">No courses found</td>
                </tr>
            <?php endif; ?>

            <!--                PHP loop        -->
            <?php
            foreach ($courses as $index => $course):
            ?>
                <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                    <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
                    <td class="py-4 px-4 text-sm"><?= $course["course_name"] ?></td>
                    <td class="py-4 px-4 text-sm"><?= $course["course_duration"] ?></td>
                    <td class="py-4 px-4 text-sm"><?= $course["course_price"] ?></td>
                    <td class="py-4 px-4 text-sm"><?= $course["course_original_price"] ?></td>
                    <td class="py-4 px-4 text-sm relative">
                        <button onclick="toggleDropdown(event, 'dropdown<?= $index + 1 ?>')" class="text-violet-600 px-4 py-2 rounded border transition duration-150 ease-in-out">Action</button>
                        <div id="dropdown<?= $index + 1 ?>" class="hidden dropdown-content absolute bg-white z-10 shadow-md rounded mt-2 w-24">
                            <a href="#" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">View</a>
                            <a href="<?= 'edit-course.php?id='. $course['course_id'] ?>" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">Edit</a>
                            <a href="#" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>


<!--    <div><a class="btn btn-danger box" href="./addCourse.php"><i class="fas fa-plus fa-2x"></i></a></div>-->
<?php
include('../mainInclude/footer.php');
?>