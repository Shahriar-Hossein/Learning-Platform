<?php
if(!isset($_SESSION)){
    session_start();
}
include '../dbConnection.php';

if(! isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php"); 
}

$courses = [];
$sql = "SELECT c.*, i.id AS instructor_id 
        FROM course c 
        LEFT JOIN instructors i ON c.instructor_id = i.id
        WHERE i.id IS NOT NULL"; // Ensure only courses with an existing instructor are selected

$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $courses[] = $row;
    }
}

// Handling course deletion
if(isset($_POST['delete'])) {
    $course_id = $_POST['course_id'];

    // Deleting course from the database
    $delete_sql = "DELETE FROM course WHERE course_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $course_id);
    if($stmt->execute()) {
        // Redirect to the same page after deletion
        header("Location: courses.php");
    } else {
        echo "Error deleting course.";
    }
}

const TITLE = 'Courses';
const PAGE = 'courses';
const DIRECTORY = '../';

include 'include/sidebar.php';
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Courses</h3>
    <p class="text-center text-lg text-gray-600 mb-2">This is the list of all the courses available on the site.</p>
</div>

<div class="flex justify-center">
  <div class="w-full bg-white shadow-lg rounded-lg overflow-auto">
    <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
      <thead>
        <tr>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">SL NO.</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Name</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Duration</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Price</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody>

      <!-- PHP If table is empty -->
      <?php if (empty($courses)): ?>
        <tr>
          <td colspan="6" class="text-center py-4">No courses found</td>
        </tr>
      <?php endif; ?>
      <!-- PHP END IF -->

      <!-- PHP LOOP START -->
      <?php foreach ($courses as $index => $course): ?>
          <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
              <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
              <td class="py-4 px-4 text-sm"><?= $course["course_name"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $course["course_duration"] ?> Days</td>
              <td class="py-4 px-4 text-sm"><?= $course["course_price"] ?> TK</td>
              <td class="py-4 px-4 text-sm">
                <!-- Delete Form -->
                <form action="courses.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                    <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
                    <button type="submit" name="delete" class="bg-red-500 text-white py-1 px-4 rounded hover:bg-red-700 transition duration-150">
                        Delete
                    </button>
                </form>
              </td>
          </tr>
      <?php endforeach; ?>
      <!-- PHP LOOP END -->
      </tbody>
    </table>
  </div>
</div>

<?php
include 'include/footer.php';
?>
