<?php
session_start();

$logged_in = isset($_SESSION['is_login']);

?>
<!-- Start Navigation -->
<nav class="bg-gray-900 fixed top-0 w-full z-20">
    <div class="container mx-auto flex flex-wrap items-center justify-between p-4">
        <!-- Company name -->
        <a href="index.php" class="text-white flex flex-col">
            <span class="text-xl">Maria's School</span>
            <span class="text-xs">Learn and Grow</span>
        </a>

        <!-- Toggle button for mobile view -->
        <button class="text-white inline-flex items-center justify-center p-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white lg:hidden" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Navbar links -->
        <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto lg:flex-row-reverse" id="navbarNav">
            <ul class="flex flex-col lg:flex-row lg:space-x-4 lg:mr-4">
                <?php if ($logged_in): ?>
                    <li class="nav-item"><a href="student/studentProfile.php" class="block px-3 py-2 rounded-md text-white hover:bg-gray-700">My Profile</a></li>
                    <li class="nav-item"><a href="logout.php" class="block px-3 py-2 rounded-md text-white hover:bg-gray-700">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="#login" class="block px-3 py-2 rounded-md text-white hover:bg-gray-700" data-toggle="modal" data-target="#stuLoginModalCenter">Login</a></li>
                    <li class="nav-item"><a href="#signup" class="block px-3 py-2 rounded-md text-white hover:bg-gray-700" data-toggle="modal" data-target="#stuRegModalCenter">Signup</a></li>
                <?php endif; ?>
            </ul>
            <ul class="flex flex-col lg:flex-row lg:space-x-4 lg:mr-4">
                <li class="nav-item"><a href="index.php" class="block px-3 py-2 rounded-md text-white hover:bg-gray-700">Home</a></li>
                <li class="nav-item"><a href="courses.php" class="block px-3 py-2 rounded-md text-white hover:bg-gray-700">Courses</a></li>
                <li class="nav-item"><a href="#Feedback" class="block px-3 py-2 rounded-md text-white hover:bg-gray-700">Feedback</a></li>
                <li class="nav-item"><a href="#Contact" class="block px-3 py-2 rounded-md text-white hover:bg-gray-700">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navigation -->