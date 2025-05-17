<?php
if(!isset($_SESSION)){
    session_start();
}
include('../dbConnection.php');

// Check if the instructor is logged in
if (!isset($_SESSION['instructor_id'])) {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

$instructor_id = $_SESSION['instructor_id'];

// Fetch instructor name from the database
$sql = "SELECT * FROM instructors WHERE id = '$instructor_id'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $instructor_name = $row['name'];
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

if (isset($_REQUEST['courseSubmitBtn'])) {
    // Checking for Empty Fields
    if (($_REQUEST['course_name'] == "") || ($_REQUEST['course_desc'] == "") || ($_REQUEST['course_duration'] == "") || ($_REQUEST['course_price'] == "") || ($_REQUEST['course_original_price'] == "")) {
        // Message displayed if required field is missing
        $msg = '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 my-2" role="alert">Fill All Fields</div>';
    } else {
        // Assigning User Values to Variables
        $course_name = $_REQUEST['course_name'];
        $course_desc = $_REQUEST['course_desc'];
        $course_duration = $_REQUEST['course_duration'];
        $course_price = $_REQUEST['course_price'];
        $course_original_price = $_REQUEST['course_original_price'];
        $course_image = $_FILES['course_img']['name'];
        $course_image_temp = $_FILES['course_img']['tmp_name'];
        $img_folder = '../image/courseimg/' . $course_image;
        move_uploaded_file($course_image_temp, $img_folder);

        $sql = "INSERT INTO course (course_name, course_desc, course_author, course_img, course_duration, course_price, course_original_price, instructor_id) 
                VALUES ('$course_name', '$course_desc', '$instructor_name', '$img_folder', '$course_duration', '$course_price', '$course_original_price', '$instructor_id')";

        if ($conn->query($sql) == TRUE) {
            // Message displayed on successful form submission
            $msg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Course Added Successfully</div>';
            $success_message = "Course added successfully!";
        } else {
            // Message displayed on failed form submission
            $msg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Add Course</div>';
            $error_message = "Failed to add course!";
        }
    }
}

const TITLE = 'Add Course';
const PAGE = 'addcourse';

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Add New Course</h3>
    <p class="text-center text-lg text-gray-600 mb-2">Fill in the details below to add a new course to the system. All fields are required.</p>
</div>

<div class="bg-white shadow-lg rounded-lg p-8">
    <?php if (isset($msg)) { echo $msg; } ?>
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
        <div class="flex flex-col">
            <label for="course_name" class="block text-violet-600 font-medium mb-2">Course Name</label>
            <input type="text" id="course_name" name="course_name"
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
            >
        </div>

        <div class="flex flex-col">
            <label for="course_desc" class="block text-violet-600 font-medium mb-2">Course Description</label>
            <textarea id="course_desc" name="course_desc" rows="4"
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
            ></textarea>
        </div>

        <div class="flex flex-col">
            <label for="course_author" class="block text-violet-600 font-medium mb-2">Author</label>
            <!-- Automatically set the instructor's name and disable the field -->
            <input type="text" id="course_author" name="course_author" value="<?= htmlspecialchars($instructor_name) ?>" readonly
                 class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none"
            >
        </div>

        <div class="flex flex-col">
            <label for="course_duration" class="block text-violet-600 font-medium mb-2">Course Duration <small> (in days 1-30) </small></label>
            <input type="number" min="2" max="30" id="course_duration" name="course_duration"
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
            >
        </div>

        <div class="flex flex-col">
            <label for="course_price" class="block text-violet-600 font-medium mb-2">Course Selling Price <small>(in tk)</small></label>
            <input type="number" min="1" id="course_price" name="course_price" onkeypress="isInputNumber(event)"
                class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
            >
        </div>

        <div class="flex flex-col">
            <label for="course_img" class="block text-violet-600 font-medium mb-2">Course Image</label>
            <input type="file" id="course_img" name="course_img"
                class="form-control-file w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
            >
        </div>

        <div class="text-center mt-6">
            <button type="submit" id="courseSubmitBtn" name="courseSubmitBtn"
                class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150"
            >Submit</button>
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
