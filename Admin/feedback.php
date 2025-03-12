<?php
if(!isset($_SESSION)){ 
  session_start(); 
}

include('../dbConnection.php');

const TITLE = 'Feedback';
const PAGE = 'feedback';
const DIRECTORY = '../';

// Check if admin is logged in
if (isset($_SESSION['admin_id'])) {
  $admin_id = $_SESSION['admin_id'];
} else {
  echo "<script> location.href='../index.php'; </script>";
  exit();
}

if(isset($_REQUEST['delete'])){
  $sql = "DELETE FROM feedback WHERE f_id = {$_REQUEST['id']}";
  $stmt = $conn->prepare($sql);
  if($stmt->execute()){
    $success_message = "Feedback deleted successfully.";
  } else {
    $error_message = "Error deleting feedback.";
  }
}

// Fetch feedbacks details
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);
$feedbacks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
}


include 'include/sidebar.php';
?>
<div class="col-sm-9 mt-5">
  <!-- Title -->
  <div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">List of feedbacks</h3>
    <p class="text-center text-lg text-gray-600 mb-2">This is the list of all feedbacks given by students.</p>
  </div>

  <!-- PHP IF BLOCK -->
  <?php if (!empty($feedbacks)) : ?>
    <div class="bg-white shadow-lg rounded-lg overflow-auto">
      <!-- Table -->
      <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
        <thead>
        <tr>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Feedback ID</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Content</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Student ID</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($feedbacks as $feedback) : ?>
          <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
            <td class="py-4 px-4 text-sm"><?= $feedback["f_id"] ?></th>
            <td class="py-4 px-4 text-sm"><?= $feedback["f_content"] ?></td>
            <td class="py-4 px-4 text-sm"><?= $feedback["stu_id"] ?></td>
            <td class="py-4 px-4 text-sm">
              <form action="" method="POST" class="d-inline">
                <input type="hidden" name="id" value='<?= $feedback["f_id"] ?>'>
                <button type="submit" value="delete" name="delete" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this feedback?');">
                    <i class="fas fa-trash-alt"></i> Delete
                  </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php include('../mainInclude/footer.php'); ?>

<script>
  const notyf = new Notyf({ position: { x: 'right', y: 'top' }, duration: 4000 });

<?php if (isset($success_message)): ?>
  notyf.success('<?= htmlspecialchars($success_message) ?>');
<?php endif; ?>
<?php if (isset($error_message)): ?>
  notyf.error('<?= htmlspecialchars($error_message) ?>');
<?php endif; ?>
  </script>
  