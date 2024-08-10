<?php
if(!isset($_SESSION)){
    session_start();
}
include('../dbConnection.php');

// Fetch all courses
$courses = [];
$sql = "SELECT * FROM course";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $courses[] = $row;
    }
}

if(isset($_POST['lessonSubmitButton'])){
    // Checking for Empty Fields
    if(empty($_POST['course_id']) || empty($_POST['lesson_name']) || empty($_POST['lesson_desc']) || empty($_FILES['lesson_video']['name'])){
        // msg displayed if required field missing
        $msg = '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 my-2" role="alert">Fill All Fields</div>';
    } else {
        // Assigning User Values to Variables
        $course_id = $_POST['course_id'];
        $lesson_name = $_POST['lesson_name'];
        $lesson_desc = $_POST['lesson_desc'];
        $lesson_video = $_FILES['lesson_video']['name'];
        $lesson_video_tmp = $_FILES['lesson_video']['tmp_name'];
        $video_folder = '../lessonvid/'. $lesson_video;
        move_uploaded_file($lesson_video_tmp, $video_folder);

        // Insert lesson into the database
        $sql = "INSERT INTO lesson (course_id, lesson_name, lesson_desc, lesson_video) VALUES ('$course_id', '$lesson_name', '$lesson_desc', '$video_folder')";
        if($conn->query($sql) === TRUE){
            $msg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Lesson Added Successfully</div>';
        } else {
            $msg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Add Lesson</div>';
        }
    }
}

const TITLE = 'Edit Course';
const PAGE = 'courses';

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Add Lesson</h3>
    <p class="text-center text-lg text-gray-600 mb-2">Add a new lesson for the course.</p>
</div>

<!-- Add Lesson Form and Lessons Table -->
<div class="bg-white shadow-lg rounded-lg p-8">
    <?php if (isset($msg)) { echo $msg; } ?>
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
        
        <div class="flex flex-col">
            <label for="course_id" class="block text-violet-600 font-medium mb-2">Course</label>
            <select id="course_id" name="course_id" required class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                <option value="" disabled selected>Select Course</option>
                <?php foreach($courses as $course): ?>
                    <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex flex-col">
            <label for="lesson_name" class="block text-violet-600 font-medium mb-2">Lesson Name</label>
            <input type="text" required id="lesson_name" name="lesson_name" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
        </div>

        <div class="flex flex-col">
            <label for="lesson_desc" class="block text-violet-600 font-medium mb-2">Lesson Description</label>
            <textarea id="lesson_desc" required name="lesson_desc" rows="4" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"></textarea>
        </div>

        <div class="flex flex-col">
            <label for="lesson_video" class="block text-violet-600 font-medium mb-2">Lesson Video</label>
            <input type="file" required id="lesson_video" name="lesson_video" class="form-control-file w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
        </div>

        <div class="text-center mt-6">
            <button type="submit" id="lessonSubmitButton" name="lessonSubmitButton" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">Submit</button>
            <a href="lessons.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150 ml-4">Close</a>
        </div>

    </form>
</div>

<?php include('../mainInclude/footer.php'); ?>
