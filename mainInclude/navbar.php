<?php
session_start();
include(DIRECTORY . "mainInclude/header.php");

// Determine the dashboard link based on user role and fetch user image
$dashboard_link = '';
$user_image = null;

if (isset($_SESSION['student_id'])) {
    $dashboard_link = "Student/dashboard.php";
    $user_id = $_SESSION['student_id'];
    $user_image_query = "SELECT image FROM student WHERE id = ?";
} elseif (isset($_SESSION['instructor_id'])) {
    $dashboard_link = "Instructor/dashboard.php";
    $user_id = $_SESSION['instructor_id'];
    $user_image_query = "SELECT image FROM instructors WHERE id = ?";
} elseif (isset($_SESSION['admin_id'])) {
    $dashboard_link = "Admin/dashboard.php";
    $user_id = $_SESSION['admin_id'];
    $user_image_query = "SELECT image FROM admin WHERE id = ?";
}

// Fetch user image if logged in
if (isset($user_id)) {
    $stmt = $conn->prepare($user_image_query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $user_image = $user_data['image'] ?: null;
    }
    $stmt->close();
}

$logged_in = isset($_SESSION['is_login']);
?>
<!-- Start Navigation -->
<nav class="bg-violet-800 fixed top-0 w-full z-20 shadow-lg">
    <div class="container mx-auto flex justify-between items-center py-2 px-4">
        <!-- Logo -->
        <a href="<?= htmlspecialchars(DIRECTORY . 'index.php') ?>" class="text-white flex items-center">
            <span class="text-xl font-extrabold">Maria's School</span>
            <span class="text-xs font-light tracking-wide ml-2">Learn and Grow</span>
        </a>

        <!-- Navigation Links -->
        <div class="flex items-center space-x-4">
            <ul class="flex space-x-4">
                <li>
                    <a href="<?= htmlspecialchars(DIRECTORY . 'index.php') ?>" class="text-white hover:bg-violet-700 px-3 py-1 rounded-md transition">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li>
                    <a href="<?= htmlspecialchars(DIRECTORY . 'courses.php') ?>" class="text-white hover:bg-violet-700 px-3 py-1 rounded-md transition">
                        <i class="fas fa-book"></i> Courses
                    </a>
                </li>
                <li>
                    <a href="#Feedback" class="text-white hover:bg-violet-700 px-3 py-1 rounded-md transition">
                        <i class="fas fa-comment-dots"></i> Feedback
                    </a>
                </li>
                <li>
                    <a href="#Contact" class="text-white hover:bg-violet-700 px-3 py-1 rounded-md transition">
                        <i class="fas fa-phone"></i> Contact
                    </a>
                </li>
            </ul>

            <?php if ($logged_in): ?>
                <!-- Dropdown for Logged-in User -->
                <div class="relative">
                    <button id="userMenu" class="text-white flex items-center space-x-2 px-3 py-1 rounded-md hover:bg-violet-700 transition">
                        <?php if ($user_image): ?>
                            <img src="<?= htmlspecialchars($user_image) ?>" alt="User Image" class="w-6 h-6 rounded-full">
                        <?php else: ?>
                            <i class="fas fa-user-circle text-xl"></i>
                        <?php endif; ?>
                        <span>My Account</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg">
                        <a href="<?= htmlspecialchars($dashboard_link) ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="<?= htmlspecialchars(DIRECTORY . 'logout.php') ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Login and Signup -->
                <div class="flex space-x-3">
                    <a href="<?= htmlspecialchars(DIRECTORY . 'auth/login.php') ?>" class="text-white hover:bg-violet-700 px-3 py-1 rounded-md transition">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="<?= htmlspecialchars(DIRECTORY . 'auth/registration.php') ?>" class="text-white hover:bg-violet-700 px-3 py-1 rounded-md transition">
                        <i class="fas fa-user-plus"></i> Signup
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- End Navigation -->

<!-- Main Content -->
<div class="mt-auto">
    <!-- Your main content goes here -->

<!-- Script to toggle dropdown -->
<script>
    document.getElementById('userMenu').addEventListener('click', () => {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
    });
</script>
