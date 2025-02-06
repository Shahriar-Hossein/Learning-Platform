<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

if(! isset($_SESSION['admin_id'])){
  header("Location: ../auth/login.php"); 
}

// Fetch lessons data securely
$lessons = [];
$sql = "SELECT * FROM lesson";
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
        </tr>
      </thead>
      <tbody>

<!-- PHP LOOP START -->
      <?php foreach ($lessons as $index => $lesson): ?>
        <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
          <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
          <td class="py-4 px-4 text-sm"><?= htmlspecialchars($lesson["course_name"]) ?></td>
          <td class="py-4 px-4 text-sm"><?= htmlspecialchars($lesson["lesson_name"]) ?></td>
        </tr>
      <?php endforeach; ?>
<!-- PHP LOOP START -->

      </tbody>
    </table>
  </div>
</div>

<?php include('../mainInclude/footer.php'); ?>


