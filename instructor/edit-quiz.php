<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Check if the quiz ID is provided
if (!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])) {
    echo "<script> location.href='quizes.php'; </script>";
    exit();
}

// Get quiz ID from query parameters
$quizId = $_GET['quiz_id'];

// Fetch quiz details from the database
$sql = "SELECT * FROM quiz WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quizId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script> location.href='quizes.php'; </script>";
    exit();
}

$quiz = $result->fetch_assoc();

if (isset($_REQUEST['quizSubmitBtn'])) {
    // Checking for Empty Fields
    if (($_REQUEST['quiz_description'] == "") || ($_FILES['quiz_file']['name'] == "" && !$quiz['file_link'])) {
        $msg = '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 my-2" role="alert">Fill All Fields</div>';
    } else {
        // Assigning User Values to Variable
        $quiz_description = $_REQUEST['quiz_description'];
        // Generating a unique file name
        $quiz_file = $_FILES['quiz_file']['name'];
        $quiz_file_tmp = $_FILES['quiz_file']['tmp_name'];

        if ($quiz_file) {
            $file_extension = pathinfo($quiz_file, PATHINFO_EXTENSION); // Get file extension
            $unique_filename = pathinfo($quiz_file, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $file_extension; // Append unique ID
            $file_folder = '../quizfiles/' . $unique_filename;
            move_uploaded_file($quiz_file_tmp, $file_folder);
            $sql = "UPDATE quiz SET description=?, file_link=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $quiz_description, $file_folder, $quizId);
        } else {
            $sql = "UPDATE quiz SET description=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $quiz_description, $quizId);
        }

        if ($stmt->execute()) {
            $msg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Quiz Updated Successfully</div>';
            $success_message = "Quiz updated successfully!";
        } else {
            $msg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Update Quiz</div>';
            $error_message = "Failed to update quiz!";
        }
    }
}

const TITLE = 'Edit Quiz';
const PAGE = 'quizes';

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Edit Quiz</h3>
    <p class="text-center text-lg text-gray-600 mb-2">Update the quiz information below.</p>
</div>

<!-- Quiz Edit Form -->
<div class="bg-white shadow-lg rounded-lg p-8 flex-1">
    <?php if (isset($msg)) { echo $msg; } ?>
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="quiz_id" value="<?= htmlspecialchars($quiz['id']) ?>">
        
        <div class="flex flex-col">
            <label for="quiz_description" class="block text-violet-600 font-medium mb-2">Quiz Description</label>
            <textarea id="quiz_description" name="quiz_description" rows="4" 
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"><?= htmlspecialchars($quiz['description']) ?></textarea>
        </div>
        
        <div class="flex flex-col">
            <label for="quiz_file" class="block text-violet-600 font-medium mb-2">Quiz File</label>
            <input type="file" id="quiz_file" name="quiz_file"
                class="form-control-file w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php if ($quiz['file_link']): ?>
                <a href="<?= $quiz['file_link'] ?>" target="_blank" class="text-blue-500 mt-2">Current File: <?= basename($quiz['file_link']) ?></a>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-6">
            <button type="submit" id="quizSubmitBtn" name="quizSubmitBtn" 
                class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                Update
            </button>
            <a href="quiz.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150 ml-4">Close</a>
        </div>
    </form>
</div>

<script>
    const notyf = new Notyf({ position: { x: 'right', y: 'top' }, duration: 4000 });

    <?php if (isset($success_message)): ?>
        notyf.success('<?= htmlspecialchars($success_message) ?>');
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        notyf.error('<?= htmlspecialchars($error_message) ?>');
    <?php endif; ?>

</script>

<?php
include('../mainInclude/footer.php');
?>

