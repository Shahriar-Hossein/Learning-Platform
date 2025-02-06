<?php
const TITLE = "Maria's School";
const PAGE = "Maria's School";
const DIRECTORY = "../";

include( DIRECTORY. "dbConnection.php");

// Function to handle login
function loginUser($email, $password, $role, $conn) {
  $table = '';
  $location = '';
  switch ($role) {
      case 'student':
          $table = 'student';
          $location = '../Student/';
          break;
      case 'instructor':
          $table = 'instructors';
          $location = '../instructor/';
          break;
      case 'admin':
          $table = 'admin';
          $location = '../Admin/';
          break;
  }
  
  $sql = "SELECT * FROM $table WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();
      if ($password == $user['password']) {
          session_start();
          $variable_name = $role . '_id';
          $_SESSION[ $variable_name] = $user['id'];
          $variable_email = $role . '_email';
          $_SESSION[ $variable_email] = $email;
          $_SESSION['role'] = $role;
          $_SESSION['is_login'] = true;

          // Redirect to dashboard or appropriate page
          header("Location: " . $location . "dashboard.php"); 
      } else {
          echo '<div class="text-red-600 text-center">Invalid password!</div>';
      }
  } else {
      echo '<div class="text-red-600 text-center">No user found with that email!</div>';
  }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $role = $_POST['role']; // 'student', 'instructor', or 'admin'
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  loginUser($email, $password, $role, $conn);
}


include( DIRECTORY. "mainInclude/navbar.php");
?>

<div class="w-full flex flex-1 items-center justify-center">
  
<!-- Login Options -->
  <div class="bg-white p-8 rounded-lg shadow-lg mt-20 max-w-md">
    <h1 class="text-2xl font-bold text-center text-violet-600 mb-6">Maria's School Login</h1>
    <div class="space-y-4">
      <a href="#student-login-form" class="block bg-violet-600 text-white py-3 px-4 rounded-md hover:bg-violet-700 w-full text-center">Student Login</a>
      <a href="#instructor-login-form" class="block bg-violet-600 text-white py-3 px-4 rounded-md hover:bg-violet-700 w-full text-center">Instructor Login</a>
      <a href="#admin-login-form" class="block bg-violet-600 text-white py-3 px-4 rounded-md hover:bg-violet-700 w-full text-center">Admin Login</a>
    </div>
    <div class="flex flex-col mt-6 items-center">
      <small class="text-gray-600 mb-2">Don't have an account?</small>
      <a href="registration.php" class="bg-white text-violet-600 border border-violet-600 py-3 px-4 rounded-md hover:bg-violet-100 text-center font-bold">
        Register
      </a>
    </div>
  </div>


  <!-- Login Forms -->
  <div id="login-forms" class="bg-gray-100 p-8 mt-20 ml-8 rounded-lg shadow-lg">

    <!-- Student Login Form -->
    <div id="student-login-form" class="login-form hidden">
      <h2 class="text-xl font-bold text-violet-600 mb-4">Student Login</h2>
      <form method="post">
        <input type="role" name="role" value="student" hidden>
        <input type="email" name="email" placeholder="Email" class="border border-gray-300 p-2 rounded-md mb-4 w-full">
        <input type="password" name="password" placeholder="Password" class="border border-gray-300 p-2 rounded-md mb-4 w-full">
        <button type="submit" class="bg-violet-600 text-white py-2 px-4 rounded-md hover:bg-violet-700 w-full">Login</button>
      </form>
    </div>

    <!-- Instructor Login Form -->
    <div id="instructor-login-form" class="login-form hidden">
      <h2 class="text-xl font-bold text-violet-600 mb-4">Instructor Login</h2>
      <form method="post">
        <input type="role" name="role" value="instructor" hidden>
        <input type="email" name="email" placeholder="Email" class="border border-gray-300 p-2 rounded-md mb-4 w-full">
        <input type="password" name="password" placeholder="Password" class="border border-gray-300 p-2 rounded-md mb-4 w-full">
        <button type="submit" class="bg-violet-600 text-white py-2 px-4 rounded-md hover:bg-violet-700 w-full">Login</button>
      </form>
    </div>

    <!-- Admin Login Form -->
    <div id="admin-login-form" class="login-form hidden">
      <h2 class="text-xl font-bold text-violet-600 mb-4">Admin Login</h2>
      <form method="post">
        <input type="role" name="role" value="admin" hidden>
        <input type="email" name="email" placeholder="Email" class="border border-gray-300 p-2 rounded-md mb-4 w-full">
        <input type="password" name="password" placeholder="Password" class="border border-gray-300 p-2 rounded-md mb-4 w-full">
        <button type="submit" class="bg-violet-600 text-white py-2 px-4 rounded-md hover:bg-violet-700 w-full">Login</button>
      </form>

    </div>
    
  </div>

</div>

<style>
  .login-form {
    display: none;
  }

  /* Show the form when its ID is targeted */
  #student-login-form:target,
  #instructor-login-form:target,
  #admin-login-form:target {
    display: block;
  }
</style>

<?php include( DIRECTORY . "mainInclude/footer.php"); ?>
