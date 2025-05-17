<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

const TITLE = 'Edit Lesson';
const PAGE = 'lessons';

// Check if the lesson ID is provided
if (!isset($_GET['lesson_id']) || empty($_GET['lesson_id'])) {
    echo "<script> location.href='lessons.php'; </script>";
    exit();
}

// Get lesson ID from query parameters
$lessonId = $_GET['lesson_id'];

// Fetch lesson details from the database
$sql = "SELECT * FROM lesson WHERE lesson_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script> location.href='lessons.php'; </script>";
    exit();
}

$lesson = $result->fetch_assoc();

if (isset($_REQUEST['lessonSubmitBtn'])) {
    // Checking for Empty Fields
    if (($_REQUEST['lesson_name'] == "") || ($_REQUEST['lesson_desc'] == "") || ($_FILES['lesson_video']['name'] == "")) {
        // msg displayed if required field missing
        $msg = '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 my-2" role="alert">Fill All Fields</div>';
    } else {
        // Assigning User Values to Variable
        $lesson_name = $_REQUEST['lesson_name'];
        $lesson_desc = $_REQUEST['lesson_desc'];
        $lesson_video = $_FILES['lesson_video']['name'];
        $lesson_video_tmp = $_FILES['lesson_video']['tmp_name'];
        $video_folder = '../lessonvid/' . $lesson_video;

        if ($lesson_video) {
            move_uploaded_file($lesson_video_tmp, $video_folder);
            $sql = "UPDATE lesson SET lesson_name=?, lesson_desc=?, lesson_link=? WHERE lesson_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $lesson_name, $lesson_desc, $video_folder, $lessonId);
        } else {
            $sql = "UPDATE lesson SET lesson_name=?, lesson_desc=? WHERE lesson_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $lesson_name, $lesson_desc, $lessonId);
        }

        if ($stmt->execute()) {
            // $msg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Lesson Updated Successfully</div>';
            echo "<script> location.href='lessons.php'; </script>";
            $success_message = "Lesson updated successfully!";
            
        } else {
            $msg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Update Lesson</div>';
            $error_message = "Failed to update lesson!";
        }
    }
}

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Edit Lesson</h3>
    <p class="text-center text-lg text-gray-600 mb-2">Update the details below to modify the lesson information.</p>
</div>

<!-- Lesson Edit Form -->
<div class="bg-white shadow-lg rounded-lg p-8 flex-1">
    <?php if (isset($msg)) { echo $msg; } ?>
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="lesson_id" value="<?= htmlspecialchars($lesson['lesson_id']) ?>">
        
        <div class="flex flex-col">
            <label for="lesson_name" class="block text-violet-600 font-medium mb-2">Lesson Name</label>
            <input type="text" id="lesson_name" name="lesson_name" value="<?= htmlspecialchars($lesson['lesson_name']) ?>" 
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" 
            >
        </div>

        <div class="flex flex-col">
            <label for="lesson_desc" class="block text-violet-600 font-medium mb-2">Lesson Description</label>
            <textarea id="lesson_desc" name="lesson_desc" rows="4" 
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"><?= htmlspecialchars($lesson['lesson_desc']) ?>
            </textarea>
        </div>

        <div class="flex flex-col">
            <label for="lesson_video" class="block text-violet-600 font-medium mb-2">Lesson Video</label>
            <input type="file" id="lesson_video" name="lesson_video"
                class="form-control-file w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
            <?php if ($lesson['lesson_link']): ?>
                <div class="mt-2 max-w-2xl mx-auto">
                    <video controls class="w-full h-64 object-contain">
                        <source src="<?= htmlspecialchars($lesson['lesson_link']) ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php endif; ?>
        </div>


        <div class="text-center mt-6">
            <button type="submit" id="lessonSubmitBtn" name="lessonSubmitBtn" 
                class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                Update
            </button>
            <a href="lessons.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150 ml-4">Close</a>
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
