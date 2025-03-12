<?php
if (!isset($_SESSION)) session_start();

include('../dbConnection.php');

const TITLE = 'Student Dashboard';
const PAGE = 'dashboard';
const DIRECTORY = '../';

// Fetch student details
$studentEmail = $_SESSION['student_email']; 
$student_id = $_SESSION['student_id'];

// Function to execute a query and fetch a single value
function getQueryValue($conn, $sql) {
    $result = $conn->query($sql);
    return $result->num_rows > 0 ? $result->fetch_assoc() : null;
}

// Fetch statistics
$activeCourses = getQueryValue($conn, "SELECT COUNT(*) AS activeCourses FROM courseorder WHERE stu_email = '$studentEmail' AND status='TXN_SUCCESS'")['activeCourses'];
$completedCourses = getQueryValue($conn, "SELECT COUNT(*) AS completedCourses FROM courseorder WHERE stu_email = '$studentEmail' AND status = 'completed'")['completedCourses'];
$averageScore = round(getQueryValue($conn, "SELECT AVG(score) AS averageScore FROM quiz_files WHERE student_id = '$student_id'")['averageScore'] ?? 0, 2);

// Fetch quizzes
$sql = "SELECT 
            q.id AS quiz_id, 
            q.course_id, 
            c.course_name, 
            q.title AS quiz_title, 
            q.description AS quiz_description
        FROM courseorder co
        INNER JOIN quiz q ON co.course_id = q.course_id
        LEFT JOIN quiz_files qf ON q.id = qf.quiz_id AND qf.student_id = (
            SELECT student_id FROM student WHERE email = co.stu_email LIMIT 1
        )
        INNER JOIN course c ON q.course_id = c.course_id
        WHERE co.stu_email = '$studentEmail' 
        AND co.status = 'TXN_SUCCESS'
        AND qf.id IS NULL -- Exclude quizzes that have been submitted
        ORDER BY q.title ASC;
        ";
$quizzes = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

// Fetch student name
$studentName = getQueryValue($conn, "SELECT name FROM student WHERE id = '$student_id'")['name'];

// Check if user came from login/registration
$showWelcomeToast = strpos($_SERVER['HTTP_REFERER'] ?? '', 'auth/login') !== false || strpos($_SERVER['HTTP_REFERER'] ?? '', 'auth/registration') !== false;

include('include/sidebar.php');
?>

<div class="container mx-auto mt-5">
    <!-- Quick Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
        <?php foreach ([
            'Active Courses' => $activeCourses, 
            'Completed Courses' => $completedCourses, 
            'Average Quiz Score' => "$averageScore%", 
            'Overall Progress' => '15%'
        ] as $label => $value): ?>
            <div class="bg-gradient-to-r from-purple-400 via-purple-500 to-purple-600 text-white rounded-lg p-6 shadow-lg text-center">
                <h2 class="text-4xl font-bold"><?= $value ?></h2>
                <p class="mt-2"><?= $label ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Graphs and Charts -->
    <div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-s mx-auto">
            <h3 class="text-xl font-semibold mb-4">Course Progress</h3>
            <!-- Smaller Chart Size -->
            <canvas id="progressChart" width="300" height="300"></canvas>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-s mx-auto">
            <h3 class="text-xl font-semibold mb-4">Skill Development</h3>
            <!-- Smaller Chart Size -->
            <canvas id="skillsChart" width="300" height="300"></canvas>
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
                            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Name</th>
                            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Quiz Description</th>
                            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Status</th>
                            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($quizzes)) : ?>
                            <?php foreach ($quizzes as $quiz): ?>
                                <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($quiz["course_name"] ?? 'No Course Name') ?></td>
                                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars(substr($quiz['quiz_description'], 0, 80) . '...')  ?></td>
                                    <td class="py-4 px-4 text-sm">
                                        <span class="px-3 py-1 rounded-lg bg-red-200 text-red-600">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-sm">
                                        <a href="view-quiz.php?quiz_id=<?= $quiz['quiz_id'] ?>&course_id=<?= $quiz['course_id'] ?>" class="text-violet-600 hover:underline">View Quiz</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                                <td colspan="4" class="py-4 px-4 text-sm text-center">No pending quizzes! Enjoy your day 😊</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const notyf = new Notyf({ position: { x: 'right', y: 'top' }, duration: 4000 });

    <?php if ($showWelcomeToast && $studentName): ?>
        notyf.success('Welcome, <?= htmlspecialchars($studentName) ?>!');
    <?php endif; ?>

    const chartOptions = (labels, data, colors) => ({
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors
            }]
        }
    });

    new Chart(document.getElementById('progressChart').getContext('2d'), chartOptions(['Completed', 'In Progress'], [<?= $completedCourses ?>, <?= $activeCourses ?>], ['#4caf50', '#ff9800']));
    new Chart(document.getElementById('skillsChart').getContext('2d'), chartOptions(['JavaScript', 'Python', 'SQL', 'HTML', 'CSS'], [85, 90, 75, 80, 70], ['rgba(54, 162, 235, 0.2)', 'rgba(54, 162, 235, 1)']));
</script>

<?php include('../mainInclude/footer.php'); ?>
