<?php
if (!isset($_SESSION)) {
    session_start();
}
const TITLE = 'My Course';
const PAGE = 'mycourse';
const DIRECTORY = '../';

include_once('../dbConnection.php');

$student = null;

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];
    
    // Prepare the SQL query to fetch student information
    $sql = "SELECT * FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $student = $result->fetch_assoc();
    }
    
    $stmt->close();
} else {
    // echo "<script>console.log(" . json_encode($_SESSION) . ");</script>";
    echo "<script> location.href='../index.php'; </script>";
}

$ordered_courses= [];
if ($student) {
    $email = $student["email"];
    $sql = "SELECT co.order_id, c.course_id, c.course_name, c.course_duration, c.course_desc, c.course_img, c.course_author, c.course_original_price, c.course_price 
            FROM courseorder AS co 
            JOIN course AS c ON c.course_id = co.course_id 
            WHERE co.stu_email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $ordered_courses[] = $row;
      }
    }
}

include('./include/sidebar.php');
?>

<div class="container mx-auto mt-5">
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h4 class="text-center text-2xl font-semibold mb-4">All Courses</h4>

    <?php foreach ($ordered_courses as $course) : ?>
      <div class="bg-violet-100 mb-4 p-4 rounded-lg shadow-md">
        <h5 class="text-xl font-bold text-violet-700 mb-2"><?php echo $course['course_name']; ?></h5>
        <div class="flex">
          <div class="flex-none w-24">
            <img src="<?php echo $course['course_img']; ?>" class="rounded-lg" alt="Course Image">
          </div>
            <div class="flex-1 ml-4">
              <p class="text-violet-600">Duration: <?php echo $course['course_duration']; ?></p>
              <p class="text-violet-600">Instructor: <?php echo $course['course_author']; ?></p>
              <p class="text-violet-600">
                Price: 
                <span class="line-through text-gray-500">&#2547;<?php echo $course['course_original_price']; ?></span> 
                <span class="font-bold">&#2547;<?php echo $course['course_price']; ?></span>
              </p>
              <a href="watchcourse.php?course_id=<?php echo $course['course_id']; ?>" class="inline-block mt-3 bg-violet-500 text-white py-2 px-4 rounded-lg transition duration-150 hover:bg-violet-600">Watch Course</a>
            </div>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- echo '<p class="text-center text-gray-600">No courses found.</p>'; -->

  </div>
</div>

<?php
include('../mainInclude/footer.php');
?>