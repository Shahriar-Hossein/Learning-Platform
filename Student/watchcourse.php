<?php
if (!isset($_SESSION)) {
  session_start();
}

const TITLE = 'Watch Course';
const PAGE = 'watch-course';
const DIRECTORY = '../';

include('../dbConnection.php');

if (isset($_SESSION['student_id'])) {
  $student_id = $_SESSION['student_id'];
} else {
  echo "<script> location.href='../index.php'; </script>";
  exit();
}

// Fetch course details and lessons
if (isset($_GET['course_id'])) {
  $course_id = $_GET['course_id'];
  $course_desc = '';
  $lessons = [];

  // Fetch course description
  $course_sql = "SELECT * FROM course WHERE course_id = '$course_id'";
  $course_result = $conn->query($course_sql);
  if ($course_result->num_rows > 0) {
    $course_row = $course_result->fetch_assoc();
    $course_desc = $course_row['course_desc'];
    $course_name = $course_row['course_name'];
  }

  // Fetch lessons
  $lessons_sql = "SELECT * FROM lesson WHERE course_id = '$course_id'";
  $lessons_result = $conn->query($lessons_sql);
  if ($lessons_result->num_rows > 0) {
    while ($lesson_row = $lessons_result->fetch_assoc()) {
      $lessons[] = $lesson_row;
    }
  }
}

include 'include/sidebar.php'; // Include the sidebar (HTML, head, body tags, etc.)
?>

<div class="container mx-auto mt-5">
  <div class="container-fluid bg-primary p-2">
    <h3 class="text-center">Lessons of </h3>
    <h3 class="text-center"><?= isset($course_name) ? $course_name : "" ?></h3>
  </div>

  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-sm-12 mb-4">
        <div class="bg-white shadow-lg rounded-lg p-4">
          <?php if (isset($course_desc)) echo '<p>' . $course_desc . '</p>'; ?>
          <!-- <video id="videoarea" src="" class="mt-5 w-full h-64 rounded-lg" controls></video> -->
        </div>
      </div>
      <div class="col-sm-12">
        <div class="bg-white shadow-lg rounded-lg p-4">
          <h4 class="text-center text-xl font-bold mb-4">Lessons</h4>
          <ul id="playlist" class="nav flex-column">
            <?php
            if (!empty($lessons)) {
              foreach ($lessons as $lesson) {
                echo '<li class="nav-item border-bottom py-2 cursor-pointer" movieurl="' . $lesson['lesson_link'] . '">' . $lesson['lesson_name'] . '</li>';
              }
            } else {
              echo '<li class="text-center py-4">No lessons available</li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include '../mainInclude/footer.php'; // Include the footer
?>
