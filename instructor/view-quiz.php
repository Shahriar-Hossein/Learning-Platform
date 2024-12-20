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
    $quiz_description = $quiz['description'];
    $quiz_file = $quiz['file_link']; // Assuming this field holds the file path of the quiz

    // Fetch all submissions for this quiz
    $submissions = [];
    $stmt = $conn->prepare("SELECT * FROM quiz_files WHERE quiz_id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $submissions[] = $row;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}

const TITLE = 'View Quiz';
const PAGE = 'quizes';

include('include/sidebar.php');
?>

<!-- Quiz Title Section -->
<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h2 class="text-center text-4xl font-extrabold my-2">Quiz</h2>
</div>

<!-- Quiz Title Section -->
<div class="my-4 py-8 bg-violet-50 text-white shadow-lg rounded-lg">
<p class="text-center text-lg text-gray-950 text-bold mb-2">Quiz Description:</p>
<p class="text-center text-lg text-gray-600 text-bold mb-2"><?= htmlspecialchars($quiz_description) ?></p>
<p class="text-center text-lg text-gray-600 mb-2">Click below to view the quiz file</p>
    <div class="text-center">
        <a href="<?= htmlspecialchars($quiz_file) ?>" target="_blank" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg">View Quiz File</a>
    </div>
</div>

<!-- Submissions List -->
<div class="my-4">
    <h4 class="text-2xl font-semibold text-violet-600 mb-4">Student Submissions</h4>
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">SL NO.</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Student Name</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Student Email</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Submitted File</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Feedback</th>
                    <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $index => $submission): ?>
                <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
                    <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
                    <?php
                    // Get student name and email
                    $stmt = $conn->prepare("SELECT first_name, last_name, email FROM students WHERE id = ?");
                    $stmt->bind_param("i", $submission['student_id']);
                    $stmt->execute();
                    $student_result = $stmt->get_result();
                    $student = $student_result->fetch_assoc();
                    $student_name = $student['first_name'] . ' ' . $student['last_name'];
                    $student_email = $student['email'];
                    ?>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($student_name) ?></td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($student_email) ?></td>
                    <td class="py-4 px-4 text-sm">
                        <a href="<?= htmlspecialchars($submission['file_link']) ?>" target="_blank" class="text-violet-600 hover:underline">View Submission</a>
                    </td>
                    <td class="py-4 px-4 text-sm"><?= htmlspecialchars($submission['feedback']) ?: 'No feedback yet' ?></td>
                    <td class="py-4 px-4 text-sm">
                        <button onclick="openFeedbackModal(<?= $submission['id'] ?>, '<?= htmlspecialchars($student_name) ?>')" class="text-violet-600 hover:text-violet-700">
                            Provide Feedback
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Feedback Modal -->
<div id="feedbackModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
        <h4 class="text-2xl font-semibold text-violet-600 mb-4">Provide Feedback</h4>
        <form action="submit_feedback.php" method="POST">
            <input type="hidden" id="quiz_file_id" name="quiz_file_id">
            <div class="mb-4">
                <label for="feedback" class="block text-violet-600 mb-2">Feedback</label>
                <select id="feedback" name="feedback" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                    <option value="Satisfactory">Satisfactory</option>
                    <option value="Very Good">Very Good</option>
                    <option value="Not Satisfactory">Not Satisfactory</option>
                    <option value="Bad">Bad</option>
                </select>
            </div>
            <div class="flex justify-between">
                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg">Submit</button>
                <button type="button" onclick="closeFeedbackModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg">Close</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openFeedbackModal(quizFileId, studentName) {
        // Show the modal and set the hidden quiz file ID
        document.getElementById('quiz_file_id').value = quizFileId;
        document.getElementById('feedbackModal').classList.remove('hidden');
    }

    function closeFeedbackModal() {
        document.getElementById('feedbackModal').classList.add('hidden');
    }
</script>

<?php include('../mainInclude/footer.php'); ?>
