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

$sql = "SELECT * FROM instructors";
$result = $conn->query($sql);
$totalInstructor = $result->num_rows;

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

    <!-- Total Instructors -->
    <div class="bg-white w-full sm:w-64 md:w-72 lg:w-80 h-40 p-4 rounded shadow-xl flex flex-col items-center justify-center text-center">
        <span class="text-3xl font-bold"> <?= $totalInstructor ?> </span>
        <span class="text-gray-600 mt-2">Total Instructors</span>
    </div>
</div>

<!-- Welcome Statement -->
<div class="pt-12 w-full mt-10 text-center">
    <h2 class="text-2xl font-semibold text-gray-800">
        Welcome to the Admin Panel!
    </h2>
    <p class="text-gray-600 mt-2">
        Manage your platform efficiently using the tools and insights provided here.
    </p>
</div>

<?php include('../mainInclude/footer.php'); ?>
