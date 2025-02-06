<?php
if (!isset($_SESSION)) {
    session_start();
}

include('../dbConnection.php');

// Fetch statistics for student
$studentEmail = $_SESSION['student_email']; // Assuming student email is stored in session
$student_id = $_SESSION['student_id'];
$sql = "SELECT COUNT(*) as activeCourses FROM courseorder WHERE stu_email = '$studentEmail'";
$result = $conn->query($sql);
$activeCourses = $result->fetch_assoc()['activeCourses'];

$sql = "SELECT COUNT(*) as completedCourses FROM courseorder WHERE stu_email = '$studentEmail' AND status = 'completed'";
$result = $conn->query($sql);
$completedCourses = $result->fetch_assoc()['completedCourses'];

$sql = "SELECT AVG(score) as averageScore FROM quiz_files WHERE student_id = '$student_id'";
$result = $conn->query($sql);
$averageScore = round($result->fetch_assoc()['averageScore']?? 0 , 2);

$sql = "
    SELECT 
        q.id AS quiz_id, 
        q.course_id, 
        c.course_name, 
        q.title AS quiz_title, 
        CASE 
            WHEN qf.id IS NULL THEN 'Pending' 
            ELSE 'Submitted' 
        END AS submission_status
    FROM 
        courseorder co
    INNER JOIN 
        quiz q ON co.course_id = q.course_id
    LEFT JOIN 
        quiz_files qf ON q.id = qf.id AND co.stu_email = qf.student_id
    INNER JOIN 
        course c ON q.course_id = c.course_id
    WHERE 
        co.stu_email = '$studentEmail'
    ORDER BY 
        submission_status DESC, q.title ASC";

$quizzes = [];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $quizzes[] = $row;
    }
}

const TITLE = 'Student Dashboard';
const PAGE = 'dashboard';
const DIRECTORY = '../';
include('include/sidebar.php');
?>

<div class="container mx-auto mt-5">

    <!-- Quick Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
        <!-- Active Courses -->
        <div class="bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 text-white rounded-lg p-6 shadow-lg text-center">
            <h2 class="text-4xl font-bold"><?= $activeCourses ?></h2>
            <p class="mt-2">Active Courses</p>
        </div>

        <!-- Completed Courses -->
        <div class="bg-gradient-to-r from-green-400 via-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg text-center">
            <h2 class="text-4xl font-bold"><?= $completedCourses ?></h2>
            <p class="mt-2">Completed Courses</p>
        </div>

        <!-- Average Score -->
        <div class="bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 text-white rounded-lg p-6 shadow-lg text-center">
            <h2 class="text-4xl font-bold"><?= $averageScore ?>%</h2>
            <p class="mt-2">Average Quiz Score</p>
        </div>

        <!-- Progress -->
        <div class="bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 text-white rounded-lg p-6 shadow-lg text-center">
            <h2 class="text-4xl font-bold">75%</h2>
            <p class="mt-2">Overall Progress</p>
        </div>
    </div>

    <!-- Graphs and Charts -->
    <div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Progress Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-4">Course Progress</h3>
            <canvas id="progressChart"></canvas>
        </div>

        <!-- Skill Trends -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-4">Skill Development</h3>
            <canvas id="skillsChart"></canvas>
        </div>
    </div>

    <!-- Pending Quizzes Section -->
    <div class="mt-12">
        <div class="my-4 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
            <h3 class="text-center text-4xl font-extrabold my-2">Quizzes Status</h3>
            <p class="text-center text-lg text-gray-200 mb-2">Check your quiz submission status below.</p>
        </div>
        
        <div class="flex justify-center">
            <div class="w-full bg-white shadow-lg rounded-lg overflow-x-auto">
                <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
                    <thead>
                        <tr>
                            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Quiz Title</th>
                            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Name</th>
                            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quizzes as $quiz): ?>
                            <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                                <td class="py-4 px-4 text-sm"><?= htmlspecialchars($quiz["quiz_title"]) ?></td>
                                <td class="py-4 px-4 text-sm"><?= htmlspecialchars($quiz["course_name"]) ?></td>
                                <td class="py-4 px-4 text-sm">
                                    <span class="px-3 py-1 rounded-lg <?= $quiz["submission_status"] === 'Pending' ? 'bg-red-200 text-red-600' : 'bg-green-200 text-green-600' ?>">
                                        <?= htmlspecialchars($quiz["submission_status"]) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Course Progress Chart
    const ctx1 = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress'],
            datasets: [{
                data: [<?= $completedCourses ?>, <?= $activeCourses ?>],
                backgroundColor: ['#4caf50', '#ff9800']
            }]
        }
    });

    // Skill Trends Chart
    const ctx2 = document.getElementById('skillsChart').getContext('2d');
    const skillsChart = new Chart(ctx2, {
        type: 'radar',
        data: {
            labels: ['JavaScript', 'Python', 'SQL', 'HTML', 'CSS'],
            datasets: [{
                label: 'Skills Level',
                data: [85, 90, 75, 80, 70],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)'
            }]
        }
    });
</script>

<?php include('../mainInclude/footer.php'); ?>
