<?php
const TITLE = "Maria's School";
const PAGE = "Maria's School";
const DIRECTORY = "../";

include(DIRECTORY . "dbConnection.php");

// Function to handle login
function loginUser($email, $password, $role, $conn) {
    $roles = [
        'student' => '../Student/',
        'instructor' => '../Instructor/',
        'admin' => '../Admin/'
    ];

    if (!array_key_exists($role, $roles)) return;
    
    $table = $role === 'instructor' ? 'instructors' : $role;

    $sql = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            session_start();
            $_SESSION[$role . '_id'] = $user['id'];
            $_SESSION[$role . '_email'] = $email;
            $_SESSION['role'] = $role;
            $_SESSION['is_login'] = true;
            echo '
                <script>
                    if (window.location.hash) {
                    history.replaceState(null, null, window.location.pathname);
                    };
                </script>
            ';
            header("Location: " . $roles[$role] . "dashboard.php");
            exit;
        }
        // Redirect with error for invalid password
        header("Location: login.php?error=Invalid password!&role=$role");
        exit;
    } else {
        // Redirect with error for no user found
        header("Location: login.php?error=No user found with that email!&role=$role");
        exit;
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    loginUser($_POST['email'], $_POST['password'], $_POST['role'], $conn);
}

include(DIRECTORY . "mainInclude/navbar.php");
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
            <a href="registration.php" class="bg-white text-violet-600 border border-violet-600 py-3 px-4 rounded-md hover:bg-violet-100 text-center font-bold">Register</a>
        </div>
    </div>

    <!-- Login Forms -->
    <div id="login-forms" class="bg-gray-100 p-8 mt-20 ml-8 rounded-lg shadow-lg">
        <?php
        $roles = ['student' => 'Student', 'instructor' => 'Instructor', 'admin' => 'Admin'];
        foreach ($roles as $roleKey => $roleName): ?>
            <div id="<?= $roleKey ?>-login-form" class="login-form hidden">
                <h2 class="text-xl font-bold text-violet-600 mb-4"><?= $roleName ?> Login</h2>
                <form method="post">
                    <input type="hidden" name="role" value="<?= $roleKey ?>">
                    <label for="email" class="block text-gray-700 font-bold mb-3">
                        Email
                    </label>
                    <input type="email" name="email" placeholder="Email" class="border border-gray-300 p-2 rounded-md mb-4 w-full">
                    <label for="password" class="block text-gray-700 font-bold mb-3">
                        Password
                    </label>
                    <input type="password" name="password" placeholder="Password" class="border border-gray-300 p-2 rounded-md mb-4 w-full">
                    <button type="submit" class="bg-violet-600 text-white py-2 px-4 rounded-md hover:bg-violet-700 w-full">Login</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .login-form { display: none; }
    #student-login-form:target, #instructor-login-form:target, #admin-login-form:target { display: block; }
</style>

<script>
    const notyf = new Notyf({
        position: { x: 'right', y: 'top' } // Top-right corner
    });

    // Check if there's an error in the query string
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const role = urlParams.get('role');

    if (error) {
        notyf.error(error);

        // Redirect to the relevant login form
        if (role) {
            const target = `#${role}-login-form`;
            if (document.querySelector(target)) {
                window.location.hash = target;
            }
        }
    }
</script>

<?php include(DIRECTORY . "mainInclude/footer.php"); ?>
