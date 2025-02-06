<?php
if (!isset($_SESSION)) {
    session_start();
}
include('../dbConnection.php');

const TITLE = 'Student Profile';
const PAGE = 'profile';
const DIRECTORY = '../';

$student = null;

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    // Fetch student information
    $sql = "SELECT * FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
    }
    $stmt->close();
} else {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

// Handle form submission
$passmsg = '';
if (isset($_REQUEST['updateStuNameBtn'])) {
    if (empty($_REQUEST['stuName'])) {
        $passmsg = '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 my-2" role="alert">Fill All Fields</div>';
    } else {
        $stuName = $_REQUEST["stuName"];
        $stuOcc = $_REQUEST["stuOcc"];
        $stu_image = $_FILES['stuImg']['name'];
        $stu_image_temp = $_FILES['stuImg']['tmp_name'];
        $img_folder = '../image/stu/' . $stu_image;

        if ($stu_image) {
            move_uploaded_file($stu_image_temp, $img_folder);
            $sql = "UPDATE student SET stu_name = ?, stu_occ = ?, stu_img = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $stuName, $stuOcc, $img_folder, $student_id);
        } else {
            $sql = "UPDATE student SET stu_name = ?, stu_occ = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $stuName, $stuOcc, $student_id);
        }

        if ($stmt->execute()) {
            $passmsg = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-2 my-2" role="alert">Updated Successfully</div>';
        } else {
            $passmsg = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 my-2" role="alert">Unable to Update</div>';
        }
        $stmt->close();
    }
}

include 'include/sidebar.php';
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Update Profile</h3>
    <p class="text-center text-lg text-gray-600 mb-2">Fill in the details below to update your profile. All fields are required.</p>
</div>

<div class="bg-white shadow-lg rounded-lg p-8">
    <?php if (isset($passmsg)) { echo $passmsg; } ?>
    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div class="flex flex-col">
            <label for="stuId" class="block text-violet-600 font-medium mb-2">Student ID</label>
            <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="stuId" name="stuId" value="<?php echo $student['id'] ?? ''; ?>" readonly>
        </div>
        <div class="flex flex-col">
            <label for="stuEmail" class="block text-violet-600 font-medium mb-2">Email</label>
            <input type="email" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="stuEmail" value="<?php echo $student['email'] ?? ''; ?>" readonly>
        </div>
        <div class="flex flex-col">
            <label for="stuName" class="block text-violet-600 font-medium mb-2">Name</label>
            <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="stuName" name="stuName" value="<?php echo $student['name'] ?? ''; ?>">
        </div>
        <div class="flex flex-col">
            <label for="stuOcc" class="block text-violet-600 font-medium mb-2">Occupation</label>
            <input type="text" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="stuOcc" name="stuOcc" value="<?php echo $student['occupation'] ?? ''; ?>">
        </div>
        <div class="flex flex-col">
            <label for="stuImg" class="block text-violet-600 font-medium mb-2">Upload Image</label>
            <input type="file" class="form-control-file w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" id="stuImg" name="stuImg">
        </div>
        <div class="text-center mt-6">
            <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150" name="updateStuNameBtn">Update</button>
        </div>
    </form>
</div>

<?php
include('../mainInclude/footer.php');
?>
