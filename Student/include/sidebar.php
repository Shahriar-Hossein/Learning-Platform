<?php
include( DIRECTORY . 'mainInclude/header.php');
?>

<!-- Navbar -->
<nav class="bg-violet-500 text-white fixed top-0 w-full z-20 shadow-lg">
    <div class="flex items-center justify-between p-4">
        <!-- Company Logo -->
        <div class="flex items-center">
            <h1 class="flex items-center text-xl font-extrabold text-violet-100 space-x-2">
                <!-- Optional Icon -->
                <svg class="w-8 h-8 text-violet-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4l2 2" />
                </svg>
                <!-- Text -->
                <span>Maria's School</span>
            </h1>
            <!-- Subtitle -->
            <p class="text-sm text-violet-300 ml-4">Student Panel</p>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div id="sidebar" class="w-64 bg-violet-400 border-r border-violet-600 text-white fixed h-full top-16 z-10 shadow-md">
    <div class="p-4">
        <nav class="space-y-2">
            <a href="dashboard.php" class="<?= TITLE == 'Dashboard' ? 'bg-violet-300' : '' ?> block py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">Dashboard</a>
            <a href="my-courses.php" class="<?= TITLE == 'Courses' ? 'bg-violet-300' : '' ?> block py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">My Courses</a>
            <a href="my-profile.php" class="<?= TITLE == 'Lessons' ? 'bg-violet-300' : '' ?> block py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">My Profile</a>
            <a href="../index.php" class="<?= TITLE == 'Home' ? 'bg-violet-300' : '' ?> block py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">Home</a>
            <a href="../logout.php" class="block py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">Logout</a>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="ml-64 mt-16 p-6">
    <!-- Your main content goes here -->
