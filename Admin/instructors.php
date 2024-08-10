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
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">instructor ID</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Name</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Email</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Occupation</th>
            <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">BIO</th>
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
  <!-- PHP CONDITION OVER -->

  <!-- PHP  Display error message if any -->
  <?php if (isset($error_message)) : ?>
    <p class="text-center text-red-500"><?= $error_message ?></p>
  <?php endif; ?>
    
</div> <!-- div col-sm-9 close -->


<?php
include '../mainInclude/footer.php' ;
?>
