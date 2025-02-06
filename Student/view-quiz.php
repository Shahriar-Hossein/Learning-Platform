<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Get quiz_id and course_id from the URL parameters
if (isset($_GET['quiz_id']) && isset($_GET['course_id'])) {
    $quiz_id = $_GET['quiz_id'];
    $course_id = $_GET['course_id'];

    // Fetch quiz title, description, and file
    $stmt = $conn->prepare("SELECT * FROM quiz WHERE id = ? AND course_id = ?");
    $stmt->bind_param("ii", $quiz_id, $course_id);
    $stmt->execute();
    $quiz_result = $stmt->get_result();
    $quiz = $quiz_result->fetch_assoc();
    $quiz_title = $quiz['title'];
    $quiz_description = $quiz['description'];
    $quiz_file = $quiz['file_link']; // Assuming this field holds the file path of the quiz

    // Check if student has already submitted the quiz
    $student_email = $_SESSION['student_email']; // Assuming the student's email is stored in the session
    $stmt = $conn->prepare("SELECT * FROM quiz_files WHERE quiz_id = ? AND student_id = (SELECT id FROM student WHERE email = ?)");
    $stmt->bind_param("is", $quiz_id, $student_email);
    $stmt->execute();
    $submission_result = $stmt->get_result();
    $submission = $submission_result->fetch_assoc();

    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}

const TITLE = 'View Quiz';
const PAGE = 'quizes';
const DIRECTORY = '../';

include('include/sidebar.php');
?>

<!-- Quiz Title Section -->
<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h2 class="text-center text-4xl font-extrabold my-2">Quiz: <?= htmlspecialchars($quiz_title ?? 'No title available') ?></h2>
</div>

<!-- Quiz Description Section -->
<div class="my-4 py-8 bg-violet-50 shadow-lg rounded-lg">
    <p class="text-center text-lg text-gray-950 text-bold mb-2">Quiz Description:</p>
    <p class="text-center text-lg text-gray-600 text-bold mb-2"><?= htmlspecialchars($quiz_description ?? 'No description available') ?></p>
    <p class="text-center text-lg text-gray-600 mb-2">Click below to view the quiz file</p>
    <div class="text-center">
        <a href="<?= htmlspecialchars($quiz_file ?? '#') ?>" target="_blank" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg">View Quiz File</a>
    </div>
</div>

<!-- Submission Status Section -->
<div class="my-4 py-8 bg-white shadow-lg rounded-lg">
    <h3 class="text-center text-2xl font-semibold text-violet-600 mb-4">Your Submission Status</h3>

    <?php if ($submission): ?>
        <p class="text-center text-lg text-gray-600 mb-2">You have already submitted the quiz file.</p>
        <p class="text-center text-lg text-gray-600 mb-2">File: <a href="<?= htmlspecialchars($submission['file_link'] ?? '#') ?>" target="_blank" class="text-violet-600 hover:underline">View Your Submitted File</a></p>

        <div class="text-center">
            <p class="text-lg text-violet-600 mb-2">Feedback:</p>
            <p class="text-center text-lg text-gray-600"><?= htmlspecialchars($submission['feedback'] ?? 'No feedback yet') ?></p>
            <p class="text-lg text-violet-600 mb-2">Score: <?= htmlspecialchars($submission['score'] ?? 'Not graded yet') ?></p>
        </div>
    <?php else: ?>
        <p class="text-center text-lg text-gray-600 mb-2">You have not submitted the quiz file yet.</p>
    <?php endif; ?>
</div>

<!-- Display submission status and messages here -->
<div id="responseMessage" class="text-center text-lg"></div>

<script>
    document.getElementById('quizSubmitForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission
        
        const formData = new FormData(this);
        const responseMessage = document.getElementById('responseMessage');

        // Clear previous response message
        responseMessage.textContent = '';
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'submit-quiz.php', true);

        // Onload event when AJAX request completes
        xhr.onload = function () {
            const response = JSON.parse(xhr.responseText);

            if (xhr.status === 200 && response.status === 'success') {
                responseMessage.innerHTML = `<p class="text-green-600">${response.message}</p>`;
                // Optionally, reload the page or update the submission status dynamically
            } else {
                responseMessage.innerHTML = `<p class="text-red-600">${response.message}</p>`;
            }
        };

        // On error during AJAX request
        xhr.onerror = function () {
            responseMessage.innerHTML = `<p class="text-red-600">An error occurred while submitting your quiz. Please try again later.</p>`;
        };

        xhr.send(formData); // Send the form data to the server
    });
</script>

<?php include('../mainInclude/footer.php'); ?>
