<?php
if(!isset($_SESSION)){
    session_start();
}
include('../dbConnection.php');

//
//if(isset($_SESSION['is_admin_login'])){
//    $adminEmail = $_SESSION['adminLogEmail'];
//} else {
//    echo "<script> location.href='../index.php'; </script>";
//}

if(isset($_REQUEST['courseSubmitBtn'])){
    // Checking for Empty Fields
    if(($_REQUEST['course_name'] == "") || ($_REQUEST['course_desc'] == "") || ($_REQUEST['course_author'] == "") || ($_REQUEST['course_duration'] == "") || ($_REQUEST['course_price'] == "") || ($_REQUEST['course_original_price'] == "")){
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
        $img_folder = '../image/courseimg/'. $course_image;
        move_uploaded_file($course_image_temp, $img_folder);
        $sql = "INSERT INTO course (course_name, course_desc, course_author, course_img, course_duration, course_price, course_original_price) VALUES ('$course_name', '$course_desc','$course_author', '$img_folder', '$course_duration', '$course_price', '$course_original_price')";
        if($conn->query($sql) == TRUE){
            // below msg display on form submit success
            $msg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Course Added Successfully</div>';
        } else {
            // below msg display on form submit failed
            $msg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Add Course</div>';
        }
    }
}

const TITLE = 'Add Course';
const PAGE = 'addcourse';

include('include/sidebar.php');
?>

<div class="flex-1 container ml-64 mt-16 p-6">
    <div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
        <h3 class="text-center text-4xl font-extrabold my-2">Add New Course</h3>
        <p class="text-center text-lg text-gray-600 mb-2">Fill in the details below to add a new course to the system. All fields are required.</p>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-8">
        <?php if (isset($msg)) { echo $msg; } ?>
        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="flex flex-col">
                <label for="course_name" class="block text-violet-600 font-medium mb-2">Course Name</label>
                <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="course_name" name="course_name">
            </div>
            <div class="flex flex-col">
                <label for="course_desc" class="block text-violet-600 font-medium mb-2">Course Description</label>
                <textarea class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="course_desc" name="course_desc" rows="4"></textarea>
            </div>
            <div class="flex flex-col">
                <label for="course_author" class="block text-violet-600 font-medium mb-2">Author</label>
                <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="course_author" name="course_author">
            </div>
            <div class="flex flex-col">
                <label for="course_duration" class="block text-violet-600 font-medium mb-2">Course Duration</label>
                <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="course_duration" name="course_duration">
            </div>
            <div class="flex flex-col">
                <label for="course_original_price" class="block text-violet-600 font-medium mb-2">Course Original Price</label>
                <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="course_original_price" name="course_original_price" onkeypress="isInputNumber(event)">
            </div>
            <div class="flex flex-col">
                <label for="course_price" class="block text-violet-600 font-medium mb-2">Course Selling Price</label>
                <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="course_price" name="course_price" onkeypress="isInputNumber(event)">
            </div>
            <div class="flex flex-col">
                <label for="course_img" class="block text-violet-600 font-medium mb-2">Course Image</label>
                <input type="file" class="form-control-file w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="course_img" name="course_img">
            </div>
            <div class="text-center mt-6">
                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150" id="courseSubmitBtn" name="courseSubmitBtn">Submit</button>
                <a href="courses.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150 ml-4">Close</a>
            </div>
        </form>
    </div>
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