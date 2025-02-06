<?php
const TITLE = "Maria's School";
const PAGE = "Maria's School Registration";
const DIRECTORY = "../";

include(DIRECTORY . "dbConnection.php");

// Function to handle registration
function registerUser($name, $occupation, $bio, $image, $email, $password, $role, $conn) {
    $table = '';
    $image_directory = '';
    $location = '';
    switch ($role) {
        case 'student':
            $table = 'student';
            $image_directory = 'stu';
            $location = '../Student/';
            break;
        case 'instructor':
            $table = 'instructors';
            $image_directory = 'instructors';
            $location = '../instructor/';
            break;
    }

    // Check if email already exists
    $sql = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $image_temp = $_FILES['image']['tmp_name'];
    $img_folder = '../image/' . $image_directory . '/'. $image;
    move_uploaded_file($image_temp, $img_folder);

    if ($result->num_rows === 0) {
        // Insert new user
        $sql = "INSERT INTO $table (name, occupation, bio, image, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $name, $occupation, $bio, $img_folder, $email, $password);
        if ($stmt->execute()) {
            echo '<div class="text-green-600 text-center">Registration successful! You can now log in.</div>';
            header("Location: " . $location . "dashboard.php");
        } else {
            echo '<div class="text-red-600 text-center">Error registering user. Please try again later.</div>';
        }
    } else {
        echo '<div class="text-red-600 text-center">Email already exists! Please use a different email.</div>';
    }
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role']; // 'student' or 'instructor'
    $name = $_POST['name'];
    $occupation = $_POST['occupation'];
    $bio = $_POST['bio'];
    $image = $_FILES['image']['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    registerUser($name, $occupation, $bio, $image, $email, $password, $role, $conn);
}

include(DIRECTORY . "mainInclude/navbar.php");
?>
<div class="w-full flex flex-row gap-6 items-start justify-center">
  
  <!-- Registration Options -->
  <div class="bg-white p-12 rounded-lg shadow-lg mt-20 max-w-lg w-full">
    <h1 class="text-3xl font-bold text-center text-violet-600 mb-8">Maria's School Registration</h1>
    <div class="space-y-6">
      <a href="#student-register-form" class="block bg-violet-600 text-white py-4 px-6 rounded-md hover:bg-violet-700 w-full text-center text-lg">Student Registration</a>
      <a href="#instructor-register-form" class="block bg-violet-600 text-white py-4 px-6 rounded-md hover:bg-violet-700 w-full text-center text-lg">Instructor Registration</a>
    </div>
    <div class="flex flex-col mt-8 items-center">
      <small class="text-gray-600 mb-3">Already have an account?</small>
      <a href="login.php" class="bg-white text-violet-600 border border-violet-600 py-3 px-6 rounded-md hover:bg-violet-100 text-center font-bold">
        Login
      </a>
    </div>
  </div>

  <!-- Registration Forms -->
  <div id="register-forms" class="bg-gray-100 p-12 mt-24 rounded-lg shadow-lg max-w-2xl w-full">

    <!-- Student Registration Form -->
    <div id="student-register-form" class="register-form hidden w-full">
      <h2 class="text-2xl font-bold text-violet-600 mb-6">Student Registration</h2>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="role" value="student">
        <div class="mb-6">
          <label for="student-name" class="block text-gray-700 font-bold mb-3">Full Name</label>
          <input type="text" id="student-name" name="name" placeholder="Full Name" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="student-occupation" class="block text-gray-700 font-bold mb-3">Occupation</label>
          <input type="text" id="student-occupation" name="occupation" placeholder="Occupation" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="student-bio" class="block text-gray-700 font-bold mb-3">Bio</label>
          <input type="text" id="student-bio" name="bio" placeholder="Bio" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="student-image" class="block text-gray-700 font-bold mb-3">Profile Picture</label>
          <input type="file" id="student-image" name="image" placeholder="image" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="student-email" class="block text-gray-700 font-bold mb-3">Email</label>
          <input type="email" id="student-email" name="email" placeholder="Email" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="student-password" class="block text-gray-700 font-bold mb-3">Password</label>
          <input type="password" id="student-password" name="password" placeholder="Password" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <button type="submit" class="bg-violet-600 text-white py-3 px-6 rounded-md hover:bg-violet-700 w-full text-lg">Register</button>
      </form>
    </div>

    <!-- Instructor Registration Form -->
    <div id="instructor-register-form" class="register-form hidden w-full">
      <h2 class="text-2xl font-bold text-violet-600 mb-6">Instructor Registration</h2>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="role" value="instructor">
        <div class="mb-6">
          <label for="instructor-name" class="block text-gray-700 font-bold mb-3">Full Name</label>
          <input type="text" id="instructor-name" name="name" placeholder="Full Name" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="instructor-occupation" class="block text-gray-700 font-bold mb-3">Occupation</label>
          <input type="text" id="instructor-occupation" name="occupation" placeholder="Occupation" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="instructor-bio" class="block text-gray-700 font-bold mb-3">Bio</label>
          <input type="text" id="instructor-bio" name="bio" placeholder="Bio" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="instructor-image" class="block text-gray-700 font-bold mb-3">Profile Picture</label>
          <input type="file" id="instructor-image" name="image" placeholder="image" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="instructor-email" class="block text-gray-700 font-bold mb-3">Email</label>
          <input type="email" id="instructor-email" name="email" placeholder="Email" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <div class="mb-6">
          <label for="instructor-password" class="block text-gray-700 font-bold mb-3">Password</label>
          <input type="password" id="instructor-password" name="password" placeholder="Password" class="border border-gray-300 p-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-violet-600" required>
        </div>
        <button type="submit" class="bg-violet-600 text-white py-3 px-6 rounded-md hover:bg-violet-700 w-full text-lg">Register</button>
      </form>
    </div>

  </div>
</div>

<style>
  .register-form {
    display: none;
  }

  /* Show the form when its ID is targeted */
  #student-register-form:target,
  #instructor-register-form:target {
    display: block;
  }
</style>


<?php include(DIRECTORY . "mainInclude/footer.php"); ?>
