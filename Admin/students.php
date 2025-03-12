<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

const TITLE = 'Students';
const PAGE = 'students';
const DIRECTORY = '../';

// Check if admin is logged in
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit();
}

// Handle delete request
if (isset($_REQUEST['delete']) && isset($_REQUEST['id'])) {
    $delete_sql = "DELETE FROM student WHERE id = {$_REQUEST['id']}";
    if ($conn->query($delete_sql) === TRUE) {
        $message = 'Student deleted successfully.';
    } else {
        $error_message = 'Unable to delete student data.';
    }
}

// Fetch student details
$sql = "SELECT * FROM student";
$result = $conn->query($sql);
$students = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

include('./include/sidebar.php');
?>

<div class="col-sm-9 mt-5">
    <!-- Title -->
    <div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
        <h3 class="text-center text-4xl font-extrabold my-2">List of Students</h3>
        <p class="text-center text-lg text-gray-600 mb-2">This is the list of all registered students.</p>
    </div>

    <!-- Table -->
    <?php if (!empty($students)) : ?>
      <div class="bg-white shadow-lg rounded-lg overflow-auto">
        <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
        <thead>
            <tr>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Student ID</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Name</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Email</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Occupation</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">BIO</th>
                <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Actions</th> <!-- Added Actions column -->
            </tr>
        </thead>
        <tbody>

        <?php foreach ($students as $student) : ?>
            <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
              <td class="py-4 px-4 text-sm"><?= $student["id"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $student["name"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $student["email"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $student["occupation"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $student["bio"] ?></td>
              <td class="py-4 px-4 text-sm">
                <!-- Delete Button Form -->
                <form action="students.php" method="GET" class="inline-block">
                  <input type="hidden" name="id" value="<?= $student['id'] ?>">
                  <button type="submit" name="delete" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this student?');">
                    <i class="fas fa-trash-alt"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
        </table>
      </div>
    <?php else : ?>
      <p class="text-center py-4">No students found</p>
    <?php endif; ?>

    <!-- Display error message if any -->
    <?php if (isset($error_message)) : ?>
        <p class="text-center text-red-500"><?= $error_message ?></p>
    <?php endif; ?>

    <!-- Display success message if any -->
    <?php if (isset($message)) : ?>
        <p class="text-center text-green-500"><?= $message ?></p>
    <?php endif; ?>

</div> <!-- div col-sm-9 close -->

<?php
include('../mainInclude/footer.php');
?>

<script>
    const notyf = new Notyf({
        position: { x: 'right', y: 'top' }, // Position the notification at the top-right corner
        duration: 4000 // The duration for which the notification will be displayed
    });

    <?php if (isset($message)) : ?>
        notyf.success('<?= htmlspecialchars($message) ?>');
    <?php endif; ?>

    <?php if (isset($error_message)) : ?>
        notyf.error('<?= htmlspecialchars($error_message) ?>');
    <?php endif; ?>
</script>
