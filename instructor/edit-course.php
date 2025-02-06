<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

// Check if the course ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script> location.href='courses.php'; </script>";
    exit();
}

// Get course ID from query parameters
$courseId = $_GET['id'];

// Fetch course details from the database
$sql = "SELECT * FROM course WHERE course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $courseId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script> location.href='courses.php'; </script>";
    exit();
}

$course = $result->fetch_assoc();

if (isset($_REQUEST['courseSubmitBtn'])) {
    // Checking for Empty Fields
    if (($_REQUEST['course_name'] == "") || ($_REQUEST['course_desc'] == "") || ($_REQUEST['course_author'] == "") || ($_REQUEST['course_duration'] == "") || ($_REQUEST['course_price'] == "") || ($_REQUEST['course_original_price'] == "")) {
        // msg displayed if required field missing
        $msg = '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 my-2" role="alert">Fill All Fields</div>';
    } else {
        // Assigning User Values to Variable
        $course_name = $_REQUEST['course_name'];
        $course_desc = $_REQUEST['course_desc'];
        $course_author = $_REQUEST['course_author'];
        $course_duration = $_REQUEST['course_duration'];
        $course_price = $_REQUEST['course_price'];
        $course_original_price = $_REQUEST['course_original_price'];
        $course_image = $_FILES['course_img']['name'];
        $course_image_temp = $_FILES['course_img']['tmp_name'];

        if ($course_image) {
            $img_folder = '../image/courseimg/'. $course_image;
            move_uploaded_file($course_image_temp, $img_folder);
            $sql = "UPDATE course SET course_name=?, course_desc=?, course_author=?, course_img=?, course_duration=?, course_price=?, course_original_price=? WHERE course_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $course_name, $course_desc, $course_author, $img_folder, $course_duration, $course_price, $course_original_price, $courseId);
        } else {
            $sql = "UPDATE course SET course_name=?, course_desc=?, course_author=?, course_duration=?, course_price=?, course_original_price=? WHERE course_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $course_name, $course_desc, $course_author, $course_duration, $course_price, $course_original_price, $courseId);
        }

        if ($stmt->execute()) {
            $msg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Course Updated Successfully</div>';
        } else {
            $msg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Update Course</div>';
        }
    }
}

const TITLE = 'Edit Course';
const PAGE = 'courses';

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Edit Course</h3>
    <p class="text-center text-lg text-gray-600 mb-2">Update the details below to modify the course information. You can also manage lessons here.</p>
</div>

<!-- Course Edit Form -->
<div class="bg-white shadow-lg rounded-lg p-8 flex-1">
    <?php if (isset($msg)) { echo $msg; } ?>
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['course_id']) ?>">
        
        <div class="flex flex-col">
            <label for="course_name" class="block text-violet-600 font-medium mb-2">Course Name</label>
            <input type="text" id="course_name" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" 
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" 
            >

        </div>

        <div class="flex flex-col">
            <label for="course_desc" class="block text-violet-600 font-medium mb-2">Course Description</label>
            <textarea id="course_desc" name="course_desc" rows="4" 
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" ><?= htmlspecialchars($course['course_desc']) ?>
            </textarea>
        </div>
        
        <div class="flex flex-col">
            
            <label for="course_author" class="block text-violet-600 font-medium mb-2">Author</label>
            <input type="text" id="course_author" name="course_author" value="<?= htmlspecialchars($course['course_author']) ?>" 
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" 
            >

        </div>
        
        <div class="flex flex-col">
            <label for="course_duration" class="block text-violet-600 font-medium mb-2">Course Duration</label>
            <input type="text" id="course_duration" name="course_duration" value="<?= htmlspecialchars($course['course_duration']) ?>"
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" 
            >
        </div>
        
        <div class="flex flex-col">
            <label for="course_original_price" class="block text-violet-600 font-medium mb-2">Course Original Price</label>
            <input type="text" id="course_original_price" name="course_original_price" value="<?= htmlspecialchars($course['course_original_price']) ?>" onkeypress="isInputNumber(event)"
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" >
        </div>
        
        <div class="flex flex-col">
            <label for="course_price" class="block text-violet-600 font-medium mb-2">Course Selling Price</label>
            <input type="text" id="course_price" name="course_price" value="<?= htmlspecialchars($course['course_price']) ?>" onkeypress="isInputNumber(event)"
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" >
        </div>
        
        <div class="flex flex-col">
            <label for="course_img" class="block text-violet-600 font-medium mb-2">Course Image</label>
            <input type="file" id="course_img" name="course_img"
                class="form-control-file w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" >
            <?php if ($course['course_img']): ?>
                <img src="<?= $course['course_img'] ?>" alt="Course Image" class="mt-2 w-32 h-32 object-cover rounded-lg">
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-6">
            <button type="submit" id="courseSubmitBtn" name="courseSubmitBtn" 
                class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150" >
                Update
            </button>
            <a href="courses.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150 ml-4">Close</a>
        </div>

    </form>
</div>

<!-- Only Number for input fields -->
<script>
    function isInputNumber(evt) {
        var ch = String.fromCharCode(evt.which);
        if (!(/[0-9]/.test(ch))) {
            evt.preventDefault();
        }
    }
</script>

<?php
include('../mainInclude/footer.php');
?>

