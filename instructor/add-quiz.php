<?php
if (!isset($_SESSION)) {
  session_start();
}
include('../dbConnection.php');

// Fetch all courses for this instructor
$courses = [];
$instructor_id = $_SESSION['instructor_id'];

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM course WHERE instructor_id = ?");
$stmt->bind_param("i", $instructor_id);
$stmt->execute();

// Fetch results securely
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
  }
}
// Close the statement
$stmt->close();

if (isset($_POST['quizSubmitButton'])) {
  // Checking for empty fields
  if (empty($_POST['course_id']) || empty($_POST['quiz_description']) || empty($_FILES['quiz_file']['name'])) {
    $msg = '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 my-2" role="alert">Fill All Fields</div>';
  } else {
    // Assigning user values to variables
    $course_id = $_POST['course_id'];
    $quiz_description = $_POST['quiz_description'];
    $quiz_file = $_FILES['quiz_file']['name'];
    $quiz_file_tmp = $_FILES['quiz_file']['tmp_name'];
    $file_folder = '../quizfiles/' . $quiz_file;
    move_uploaded_file($quiz_file_tmp, $file_folder);

    // Insert quiz into the database
    $insert_stmt = $conn->prepare("INSERT INTO quiz (course_id, description, file_link) VALUES (?, ?, ?)");
    $insert_stmt->bind_param("iss", $course_id, $quiz_description, $file_folder);

    if ($insert_stmt->execute()) {
      $msg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Quiz Added Successfully</div>';
    } else {
      $msg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Add Quiz</div>';
    }

    $insert_stmt->close();
  }
}

const TITLE = 'Add Quiz';
const PAGE = 'quizes';

include('include/sidebar.php');
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
  <h3 class="text-center text-4xl font-extrabold my-2">Add Quiz</h3>
  <p class="text-center text-lg text-gray-600 mb-2">Add a new quiz for a course.</p>
</div>

<!-- Add Quiz Form -->
<div class="bg-white shadow-lg rounded-lg p-8">
  <?php if (isset($msg)) {
    echo $msg;
  } ?>
  <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">

    <div class="flex flex-col">
      <label for="course_id" class="block text-violet-600 font-medium mb-2">Course</label>
      <select id="course_id" name="course_id" required class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
        <option value="" disabled selected>Select Course</option>
        <?php foreach ($courses as $course): ?>
          <option value="<?php echo $course['course_id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="flex flex-col">
      <label for="quiz_description" class="block text-violet-600 font-medium mb-2">Quiz Description</label>
      <textarea id="quiz_description" required name="quiz_description" rows="4" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"></textarea>
    </div>

    <div class="flex flex-col">
      <label for="quiz_file" class="block text-violet-600 font-medium mb-2">Quiz File</label>
      <input type="file" required id="quiz_file" name="quiz_file" class="form-control-file w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
    </div>

    <div class="text-center mt-6">
      <button type="submit" id="quizSubmitButton" name="quizSubmitButton" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150">Submit</button>
      <a href="quiz.php" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150 ml-4">Close</a>
    </div>

  </form>
</div>

<?php include('../mainInclude/footer.php'); ?>
