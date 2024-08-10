<?php
if (!isset($_SESSION)) {
    session_start();
}

include('../dbConnection.php');

$sql = "SELECT * FROM course";
$result = $conn->query($sql);
$totalCourse = $result->num_rows;

$sql = "SELECT * FROM student";
$result = $conn->query($sql);
$totalStudent = $result->num_rows;

$sql = "SELECT * FROM courseorder";
$result = $conn->query($sql);
$totalSold = $result->num_rows;

$sql = "SELECT co.*, c.course_name, c.course_price
        FROM courseorder co
        INNER JOIN course c ON co.course_id = c.course_id";
$orderedCourses = [];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderedCourses[] = $row;
    }
}

const TITLE = 'Dashboard';
const PAGE = 'dashboard';
const DIRECTORY = '../';

include 'include/sidebar.php';
?>

<!-- Squares Container -->
<div class="flex flex-wrap justify-center gap-6 w-full pt-12">
    <!-- Total Students -->
    <div class="bg-white w-full sm:w-64 md:w-72 lg:w-80 h-40 p-4 rounded shadow-xl flex flex-col items-center justify-center text-center">
        <span class="text-3xl font-bold"> <?= $totalStudent ?> </span>
        <span class="text-gray-600 mt-2">Total Students</span>
    </div>

    <!-- Total Courses -->
    <div class="bg-white w-full sm:w-64 md:w-72 lg:w-80 h-40 p-4 rounded shadow-xl flex flex-col items-center justify-center text-center">
        <span class="text-3xl font-bold"> <?= $totalCourse ?> </span>
        <span class="text-gray-600 mt-2">Total Courses</span>
    </div>

    <!-- Sold Courses -->
    <div class="bg-white w-full sm:w-64 md:w-72 lg:w-80 h-40 p-4 rounded shadow-xl flex flex-col items-center justify-center text-center">
        <span class="text-3xl font-bold"> <?= $totalSold ?> </span>
        <span class="text-gray-600 mt-2">Sold Courses</span>
    </div>
</div>

<div class="pt-12">
    <div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
        <h3 class="text-center text-4xl font-extrabold my-2">Ordered Courses</h3>
        <p class="text-center text-lg text-gray-600 mb-2">This is the list of all the ordered courses.</p>
    </div>
    
    <div class="flex justify-center ">
        <div class="w-full bg-white shadow-lg rounded-lg overflow-x-auto">
            <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
                <thead>
                    <tr>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Order ID</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course ID</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Student Email</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Order Date</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Amount</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderedCourses as $index => $order): ?>
                        <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                            <td class="py-4 px-4 text-sm"><?= $order["order_id"] ?></td>
                            <td class="py-4 px-4 text-sm"><?= $order["course_id"] ?></td>
                            <td class="py-4 px-4 text-sm"><?= $order["stu_email"] ?></td>
                            <td class="py-4 px-4 text-sm"><?= $order["order_date"] ?></td>
                            <td class="py-4 px-4 text-sm"><?= $order["course_price"] ?></td>
                            <td class="py-4 px-4 text-sm relative">
                                <button onclick="toggleDropdown(event, 'dropdown<?= $index + 1 ?>')" class="text-violet-600 px-4 py-2 rounded border transition duration-150 ease-in-out">Action</button>
                                <div id="dropdown<?= $index + 1 ?>" class="hidden dropdown-content absolute bg-white z-10 shadow-md rounded mt-2 min-w-24">
                                    <a href="#" class="block px-4 py-2 text-violet-800 hover:bg-violet-200">View</a>
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
</div>

<?php include('../mainInclude/footer.php'); ?>
