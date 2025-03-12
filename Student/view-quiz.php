<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include('../dbConnection.php');
date_default_timezone_set('Asia/Dhaka');

const TITLE = 'View Quiz';
const PAGE = 'quizzes';
const DIRECTORY = '../';

if (!isset($_GET['quiz_id'], $_GET['course_id'])) {
    exit('Invalid request.');
}

$quiz_id = $_GET['quiz_id'];
$course_id = $_GET['course_id'];
$student_id = $_SESSION['student_id'];

// Fetch quiz details
$stmt = $conn->prepare("SELECT * FROM quiz WHERE id = ? AND course_id = ?");
$stmt->bind_param("ii", $quiz_id, $course_id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch student submission
$stmt = $conn->prepare("SELECT * FROM quiz_files WHERE quiz_id = ? AND student_id = ?");
$stmt->bind_param("ii", $quiz_id, $student_id);
$stmt->execute();
$submission = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$submission) {
    echo '
    <script>
        window.onload = function () {
            if (!confirm("Are you sure you want to start the quiz? You cannot leave or reload once started.")) {
                window.location.href = "my-courses.php";
            } else {
                fetch("submit-quiz.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ quiz_id: ' . $quiz_id . ' })
                })
                .then(response => response.json())
                .then(result => result.status === "success" && location.reload())
                .catch(() => alert("Failed to start the quiz. Please try again later."));
            }
        }
    </script>';
    exit;
}

$created_at = $submission['created_at'];  // MySQL datetime string (e.g., '2025-02-10 14:22:37')
$quiz_time = $quiz['time'];  // Time in minutes

// Create DateTime object from the created_at string
$date = new DateTime($created_at);

// Add quiz time (in minutes) to the created_at timestamp
$date->add(new DateInterval("PT{$quiz_time}M"));

// Get the end time as Unix timestamp
$end_time = $date->getTimestamp();

// Calculate the remaining time (in seconds)
$time_remaining = max($end_time - time(), 0);  // Ensure it doesn't go below 0
echo '
<script>
    console.log('. $end_time .');
    console.log("' . time() .'");
</script>
';

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg text-center">
    <h2 class="text-4xl font-extrabold">Quiz</h2>
</div>

<div class="my-4 py-8 bg-violet-50 shadow-lg rounded-lg text-center">
    <p class="text-lg text-gray-950 font-bold mb-2">Quiz Description:</p>
    <p class="text-lg text-gray-600 mb-2"><?= htmlspecialchars($quiz['description'] ?? 'No description available') ?></p>
    <a href="<?= htmlspecialchars($quiz['file_link'] ?? '#') ?>" target="_blank" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg">View Quiz File</a>
</div>

<div class="my-4 py-8 bg-white shadow-lg rounded-lg text-center">
    <h3 class="text-2xl font-semibold text-violet-600 mb-4">Your Submission Status</h3>
    
    <?php if ($submission['file_link']): ?>
        <p class="text-lg text-gray-600">You have already submitted the quiz file.</p>
        <p class="text-lg text-gray-600">File: <a href="<?= htmlspecialchars($submission['file_link']) ?>" target="_blank" class="text-violet-600 hover:underline">View Your Submitted File</a></p>
        <p class="text-lg text-violet-600">Feedback:</p>
        <p class="text-lg text-gray-600 mb-2"><?= htmlspecialchars($submission['feedback'] ?? 'No feedback yet') ?></p>
        <p class="text-lg text-violet-600">Score: <?= htmlspecialchars($submission['score'] ?? 'Not graded yet') ?></p>
    <?php else: ?>
        <div id="quizTimer" class="text-xl font-bold text-red-600 my-4"></div>
        <?php if ($time_remaining > 0): ?>
            <form id="quizSubmitForm" method="POST" enctype="multipart/form-data" class="text-center">
                <input type="hidden" name="quiz_id" value="<?= htmlspecialchars($quiz_id) ?>">
                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course_id) ?>">
                <input type="file" name="quiz_file" accept=".pdf,.doc,.docx,.jpg,.png" required class="block mx-auto my-3 p-2 border border-gray-300 rounded-lg">
                <button id="quizSubmitButton" type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg">Submit Quiz</button>
            </form>
        <?php else: ?>
            <p class="text-lg text-red-600 font-bold">Time is up! You can no longer submit the quiz.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
    const disableSubmission = () => {
        let submitButton = document.getElementById('quizSubmitButton');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.style.cursor = "not-allowed";
            submitButton.style.opacity = "0.6";
            document.getElementById('quizTimer').innerText = "Time is up! You can no longer submit the quiz.";
        }
    };

    <?php if ($time_remaining > 0): ?>
        let timeRemaining = <?= $time_remaining ?>;
        const startTimer = () => {
            let timerInterval = setInterval(() => {
                let minutes = Math.floor(timeRemaining / 60);
                let seconds = timeRemaining % 60;
                document.getElementById('quizTimer').innerText = `Time Left: ${minutes}m ${seconds}s`;
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    disableSubmission();
                }
                timeRemaining--;
            }, 1000);
        };
        startTimer();
        
        window.onbeforeunload = () => "Are you sure you want to leave? Your progress will be lost!";
        history.pushState(null, null, location.href);
        window.onpopstate = () => history.pushState(null, null, location.href);
    <?php else: ?>
        disableSubmission();
    <?php endif; ?>

    document.getElementById('quizSubmitForm')?.addEventListener('submit', function (event) {
        event.preventDefault();
        let formData = new FormData(this);
        fetch("submit-quiz.php", { method: "POST", body: formData })
        .then(response => response.json())
        .then(result => {
            document.getElementById('quizTimer').innerHTML = `<p class="text-${result.status === 'success' ? 'green' : 'red'}-600">${result.message}</p>`;
            if (result.status === 'success') setTimeout(() => location.reload(), 3000);
        })
        .catch(() => document.getElementById('quizTimer').innerHTML = '<p class="text-red-600">An error occurred while submitting. Please try again.</p>');
    });
</script>

<?php include('../mainInclude/footer.php'); ?>
