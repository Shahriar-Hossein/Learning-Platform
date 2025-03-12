<?php
session_start();
include('../dbConnection.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php"); 
    exit();
}

// Check if lesson_id is posted for deletion
if (isset($_POST['lesson_id'])) {
    $lesson_id = $_POST['lesson_id'];

    // Prepare SQL query to delete the lesson
    $sql = "DELETE FROM lesson WHERE lesson_id = ?";
    $stmt = $conn->prepare($sql);

    // Bind the lesson_id and execute
    $stmt->bind_param('i', $lesson_id);

    if ($stmt->execute()) {
        $message = "Lesson deleted successfully.";
    } else {
        $message = "Error deleting lesson.";
    }

    $stmt->close();
}

// Fetch lessons data securely, only fetching lessons whose associated course exists
$lessons = [];
$sql = "
    SELECT lesson.*, course.course_name
    FROM lesson
    JOIN course ON lesson.course_id = course.course_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lessons[] = $row;
    }
}


const TITLE = 'Lessons';
const PAGE = 'lessons';
const DIRECTORY = '../';

include('include/sidebar.php');
?>

<!-- Display message if there is any -->
<?php if (isset($message)): ?>
    <div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
        <p class="text-center text-lg"><?= htmlspecialchars($message) ?></p>
    </div>
<?php endif; ?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
  <h3 class="text-center text-4xl font-extrabold my-2">Lessons</h3>
  <p class="text-center text-lg text-gray-600 mb-2">This is the list of all the lessons available on the site.</p>
</div>

<div class="flex justify-center">
  <div class="w-full bg-white shadow-lg rounded-lg overflow-x-auto">
    <table class="min-w-full leading-normal">
      <thead>
        <tr>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">SL NO.</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Name</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Lesson Name</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Actions</th> <!-- Added Actions column -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lessons as $index => $lesson): ?>
          <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
            <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
            <td class="py-4 px-4 text-sm"><?= htmlspecialchars($lesson["course_name"]) ?></td>
            <td class="py-4 px-4 text-sm"><?= htmlspecialchars($lesson["lesson_name"]) ?></td>
            <td class="py-4 px-4 text-sm">
              <!-- Delete Button Form -->
              <form action="lessons.php" method="POST" class="inline-block">
                <input type="hidden" name="lesson_id" value="<?= $lesson['lesson_id'] ?>">
                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this lesson?');">
                  <i class="fas fa-trash-alt"></i> Delete
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('../mainInclude/footer.php'); ?>
