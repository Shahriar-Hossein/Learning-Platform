<?php
const TITLE = "Maria's School";
const PAGE = "Maria's School Registration";
const DIRECTORY = "../";

include(DIRECTORY . "dbConnection.php");

// Function to handle registration
function registerUser($name, $occupation, $bio, $image, $email, $password, $role, $conn) {
    $roles = [
        'student' => ['table' => 'student', 'dir' => 'stu', 'location' => '../Student/'],
        'instructor' => ['table' => 'instructors', 'dir' => 'instructors', 'location' => '../instructor/']
    ];

    if (!isset($roles[$role])) {
        echo '<script>notyf.error("Invalid role specified!");</script>';
        return;
    }

    $table = $roles[$role]['table'];
    $image_directory = $roles[$role]['dir'];
    $location = $roles[$role]['location'];

    // Check if email already exists
    $sql = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $image_temp = $_FILES['image']['tmp_name'];
    $img_folder = '../image/' . $image_directory . '/' . $image;
    move_uploaded_file($image_temp, $img_folder);

    if ($result->num_rows === 0) {
        // Insert new user
        $sql = "INSERT INTO $table (name, occupation, bio, image, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $name, $occupation, $bio, $img_folder, $email, $password);

        if ($stmt->execute()) {
            // Start a session and store user information
            session_start();
            $user_id = $stmt->insert_id; // Get the newly inserted user's ID
            $_SESSION["{$role}_id"] = $user_id;
            $_SESSION["{$role}_email"] = $email;
            $_SESSION['is_login'] = true;

            // Redirect to dashboard
            header("Location: " . $location . "dashboard.php");
            exit;
        } else {
            echo '<script>notyf.error("Error registering user. Please try again later.");</script>';
        }
    } else {
        echo '<script>notyf.error("Email already exists! Please use a different email.");</script>';
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
    $confirm_password = $_POST['confirm_password'];

    // Server-side password matching validation
    if ($password !== $confirm_password) {
        echo '<script>notyf.error("Passwords do not match!");</script>';
    } else {
        registerUser($name, $occupation, $bio, $image, $email, $password, $role, $conn);
    }
}

include(DIRECTORY . "mainInclude/navbar.php");
?>
<div class="min-h-screen flex items-center justify-center bg-gray-100">
  <!-- Container -->
  <div class="bg-white shadow-lg rounded-lg max-w-5xl w-full flex flex-row overflow-hidden">
    <!-- Registration Options -->
    <div class="bg-violet-600 text-white flex flex-col items-center justify-center p-10 w-1/3">
      <h1 class="text-3xl font-bold mb-6">Welcome to Maria's School</h1>
      <p class="text-center text-lg mb-8">Choose your role to get started:</p>
      <div class="space-y-4 w-full">
        <?php foreach (["student" => "Student", "instructor" => "Instructor"] as $key => $label): ?>
          <a href="#<?= $key ?>-register-form" class="block bg-white text-violet-600 py-3 px-4 rounded-md hover:bg-violet-100 text-center font-bold transition w-full">
            <?= $label ?> Registration
          </a>
        <?php endforeach; ?>
      </div>
      <div class="mt-10">
        <small class="block mb-3">Already have an account?</small>
        <a href="login.php" class="bg-white text-violet-600 py-2 px-6 rounded-md hover:bg-violet-100 text-center font-bold">
          Login
        </a>
      </div>
    </div>

    <!-- Registration Forms -->
    <div id="register-forms" class="p-10 w-2/3 bg-gray-50">
      <?php foreach (["student" => "Student", "instructor" => "Instructor"] as $key => $label): ?>
        <div id="<?= $key ?>-register-form" class="register-form hidden">
          <h2 class="text-2xl font-bold text-violet-600 mb-6"><?= $label ?> Registration</h2>
          <form method="post" enctype="multipart/form-data" onsubmit="return validatePasswords(this)" class="space-y-4">
            <input type="hidden" name="role" value="<?= $key ?>">
            <?php foreach ([
              'name' => 'Full Name',
              'occupation' => 'Occupation',
              'bio' => 'Bio',
              'image' => 'Profile Picture',
              'email' => 'Email',
              'password' => 'Password',
              'confirm_password' => 'Confirm Password'
            ] as $field => $placeholder): ?>
              <div>
                <label for="<?= $key . '-' . $field ?>" class="block text-sm font-medium text-gray-700 mb-2">
                  <?= $placeholder ?>
                </label>
                <input 
                  type="<?= in_array($field, ['password', 'confirm_password']) ? 'password' : ($field === 'image' ? 'file' : 'text') ?>"
                  id="<?= $key . '-' . $field ?>" 
                  name="<?= $field ?>" 
                  placeholder="<?= $placeholder ?>" 
                  class="border border-gray-300 p-3 rounded-md w-full focus:ring-2 focus:ring-violet-600 focus:outline-none text-sm" 
                  <?= $field !== 'bio' ? 'required' : '' ?>
                >
              </div>
            <?php endforeach; ?>
            <button type="submit" class="bg-violet-600 text-white py-3 px-6 rounded-md hover:bg-violet-700 w-full text-sm font-bold transition">
              Register
            </button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<style>
  .register-form {
    display: none;
  }
  #student-register-form:target,
  #instructor-register-form:target {
    display: block;
  }
</style>

<!-- Notyf Library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
  const notyf = new Notyf({
    duration: 4000,
    position: { x: 'right', y: 'top' },
    types: [
      {
        type: 'error',
        background: 'red',
        icon: { className: 'fas fa-exclamation-circle', tagName: 'i' },
      },
    ],
  });

  function validatePasswords(form) {
    const password = form.querySelector('[name="password"]').value;
    const confirmPassword = form.querySelector('[name="confirm_password"]').value;

    if (password !== confirmPassword) {
      notyf.error("Passwords do not match!");
      return false;
    }
    return true;
  }
</script>

<?php include(DIRECTORY . "mainInclude/footer.php"); ?>
