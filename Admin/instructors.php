<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

const TITLE = 'Instructors';
const PAGE = 'instructors';
const DIRECTORY = '../';

// Check if admin is logged in
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit();
}

// Check if instructor_id is posted for deletion
if (isset($_POST['instructor_id'])) {
    $instructor_id = $_POST['instructor_id'];

    // Prepare SQL query to delete the instructor
    $sql = "DELETE FROM instructors WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind the instructor_id and execute
    $stmt->bind_param('i', $instructor_id);

    if ($stmt->execute()) {
        $message = "Instructor deleted successfully.";
    } else {
        $error_message = "Error deleting instructor.";
    }

    $stmt->close();
}

// Fetch instructor details
$sql = "SELECT * FROM instructors";
$result = $conn->query($sql);
$instructors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $instructors[] = $row;
    }
}

include('./include/sidebar.php');
?>

<div class="col-sm-9 mt-5">
  <!-- Title -->
  <div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">List of instructors</h3>
    <p class="text-center text-lg text-gray-600 mb-2">This is the list of all registered instructors.</p>
  </div>

  <!-- PHP IF BLOCK -->
  <?php if (!empty($instructors)) : ?>
    <div class="bg-white shadow-lg rounded-lg overflow-auto">
      <!-- Table -->
      <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
        <thead>
          <tr>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Instructor ID</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Name</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Email</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Occupation</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">BIO</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Actions</th> <!-- Added Actions column -->
          </tr>
        </thead>
        <tbody>
          <!-- PHP LOOP START -->
          <?php foreach ($instructors as $instructor) : ?>
            <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
              <td class="py-4 px-4 text-sm"><?= $instructor["id"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $instructor["name"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $instructor["email"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $instructor["occupation"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $instructor["bio"] ?></td>
              <td class="py-4 px-4 text-sm">
                <!-- Delete Button Form -->
                <form action="instructors.php" method="POST" class="inline-block">
                  <input type="hidden" name="instructor_id" value="<?= $instructor['id'] ?>">
                  <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this instructor?');">
                    <i class="fas fa-trash-alt"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          <!-- PHP LOOP END -->
        </tbody>
      </table>
    </div>
  <!-- PHP ELSE BLOCK -->
  <?php else : ?>
    <p class="text-center py-4">No instructors found</p>
  <?php endif; ?>

</div> <!-- div col-sm-9 close -->

<?php
include '../mainInclude/footer.php';
?>

<script>
    // Display Notyf notifications
  const notyf = new Notyf({
    position: { x: 'right', y: 'top' }, // Position the notification at the top-right corner
    duration: 4000 // The duration for which the notification will be displayed
  });
  <?php if (isset($message)) : ?>
        notyf.success('<?= htmlspecialchars($message) ?>');
        unset($message);
    <?php endif; ?>

    <?php if (isset($error_message)) : ?>
        notyf.error('<?= htmlspecialchars($error_message) ?>');
        unset($error_message);
    <?php endif; ?>
</script>
