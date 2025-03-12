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

$instructor_id = $_SESSION['instructor_id'];

// Fetch courses created by the instructor
$sql = "SELECT * FROM course WHERE instructor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}
$totalCourse = count($courses);

// Fetch course orders for the instructor's courses
$orderedCourses = [];
$totalSold = 0;
$studentEmails = [];
foreach ($courses as $course) {
    $course_id = $course['course_id'];
    $sql = "SELECT co.*, c.course_name, c.course_price
            FROM courseorder co
            INNER JOIN course c ON co.course_id = c.course_id
            WHERE c.course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $orderedCourses[] = $row;
        $totalSold++;
        $studentEmails[] = $row['stu_email'];
    }
}

// Calculate the number of unique students
$totalStudent = count(array_unique($studentEmails));

// Function to execute a query and fetch a single value
function getQueryValue($conn, $sql) {
    $result = $conn->query($sql);
    return $result->num_rows > 0 ? $result->fetch_assoc() : null;
}
// Fetch instructor name
$instructorName = getQueryValue($conn, "SELECT name FROM instructors WHERE id = '$instructor_id'")['name'];

// Check if user came from login/registration
$showWelcomeToast = strpos($_SERVER['HTTP_REFERER'] ?? '', 'auth/login') !== false || strpos($_SERVER['HTTP_REFERER'] ?? '', 'auth/registration') !== false;


const TITLE = 'Dashboard';
const PAGE = 'dashboard';

include('include/sidebar.php');
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
        <p class="text-center text-lg text-gray-600 mb-2">This is the list of all the ordered courses for your account.</p>
    </div>
    
    <div class="flex justify-center">
        <div class="w-full bg-white shadow-lg rounded-lg overflow-x-auto">
            <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
                <thead>
                    <tr>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Order ID</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Name</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Student Email</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Order Date</th>
                        <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderedCourses as $order): ?>
                        <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                            <td class="py-4 px-4 text-sm"><?= $order["order_id"] ?></td>
                            <td class="py-4 px-4 text-sm"><?= $order["course_name"] ?></td>
                            <td class="py-4 px-4 text-sm"><?= $order["stu_email"] ?></td>
                            <td class="py-4 px-4 text-sm"><?= $order["order_date"] ?></td>
                            <td class="py-4 px-4 text-sm"><?= $order["course_price"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($orderedCourses)): ?>
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-gray-600">No orders found for your courses.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const notyf = new Notyf({ position: { x: 'right', y: 'top' }, duration: 4000 });

<?php if ($showWelcomeToast && $instructorName): ?>
    notyf.success('Welcome, <?= htmlspecialchars($instructorName) ?>!');
<?php endif; ?>

</script>

<?php include('../mainInclude/footer.php'); ?>
