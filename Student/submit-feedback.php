<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

const TITLE = 'Feedback';
const PAGE = 'feedback';
const DIRECTORY = '../';

$student = null;
$passmsg = '';
$existingFeedback = '';

if (isset($_SESSION['student_email'])) {
    $stuEmail = $_SESSION['student_email'];

    // Fetch student information
    $sql = "SELECT * FROM student WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $stuEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
    }
    $stmt->close();

    // Fetch existing feedback
    $sql = "SELECT f_content FROM feedback WHERE stu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $feedbackRow = $result->fetch_assoc();
        $existingFeedback = $feedbackRow['f_content'];
    }
    $stmt->close();
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

// Handle feedback submission
if (isset($_POST['submitFeedbackBtn'])) {
    if (empty($_POST['f_content'])) {
        $passmsg = '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 my-2" role="alert">Fill All Fields</div>';
    } else {
        $fcontent = $_POST['f_content'];
        $stuId = $student['id'];

        if ($existingFeedback) {
            $sql = "UPDATE feedback SET f_content = ? WHERE stu_id = ?";
        } else {
            $sql = "INSERT INTO feedback (f_content, stu_id) VALUES (?, ?)";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $fcontent, $stuId);
        
        if ($stmt->execute()) {
            $passmsg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Submitted Successfully</div>';
            $existingFeedback = $fcontent;
        } else {
            $passmsg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Submit</div>';
        }
        $stmt->close();
    }
}

include 'include/sidebar.php';
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Submit Feedback</h3>
    <p class="text-center text-lg text-gray-600 mb-2">We appreciate your feedback. Please share your thoughts below.</p>
</div>

<div class="bg-white shadow-lg rounded-lg p-8">
    <?php if (!empty($passmsg)) { echo $passmsg; } ?>
    <form method="POST" class="space-y-6">
        <div class="flex flex-col">
            <label for="stuId" class="block text-violet-600 font-medium mb-2">Student ID</label>
            <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="stuId" name="stuId" value="<?php echo $student['id'] ?? ''; ?>" readonly>
        </div>
        <div class="flex flex-col">
            <label for="stuName" class="block text-violet-600 font-medium mb-2">Student Name</label>
            <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="stuId" name="stuId" value="<?php echo $student['name'] ?? ''; ?>" readonly>
        </div>
        <div class="flex flex-col">
            <label for="f_content" class="block text-violet-600 font-medium mb-2">Write Feedback</label>
            <textarea class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="f_content" name="f_content" rows="4" required><?php echo htmlspecialchars($existingFeedback); ?></textarea>
        </div>
        <div class="text-center mt-6">
            <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150" name="submitFeedbackBtn">Submit</button>
        </div>
    </form>
</div>

<?php
include('../mainInclude/footer.php');
?>
