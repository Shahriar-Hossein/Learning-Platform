<?php include '../mainInclude/header.php'; ?>

<!-- Navbar -->
<nav class="bg-violet-500 text-white fixed top-0 w-full z-20 shadow-lg">
    <div class="flex items-center justify-between p-4">
        <!-- Company Logo -->
        <div class="flex items-center">
            <h1 class="flex items-center text-xl font-extrabold text-violet-100 space-x-2">
                <svg class="w-8 h-8 text-violet-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4l2 2" />
                </svg>
                <span>Maria's School</span>
            </h1>
            <p class="text-sm text-violet-300 ml-4">Admin Panel</p>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div id="sidebar" class="w-64 bg-violet-400 border-r border-violet-600 text-white fixed h-full top-16 z-10 shadow-md">
    <div class="p-4">
        <nav class="space-y-2">
            <a href="dashboard.php" class="<?= TITLE == 'Dashboard' ? 'bg-violet-300' : '' ?> flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16M4 6h16M4 18h16" />
                </svg>
                Dashboard
            </a>
            <a href="courses.php" class="<?= TITLE == 'Courses' ? 'bg-violet-300' : '' ?> flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h8M8 12h8m-8 6h4" />
                </svg>
                Courses
            </a>
            <a href="lessons.php" class="<?= TITLE == 'Lessons' ? 'bg-violet-300' : '' ?> flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6l-2 2m0 0l2 2m-2-2h8m0 0l-2 2m2-2l-2-2" />
                </svg>
                Lessons
            </a>
            <a href="orders.php" class="<?= TITLE == 'Orders' ? 'bg-violet-300' : '' ?> flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4V4zm4 4h8v2H8V8zm0 4h8v2H8v-2z" />
                </svg>
                Orders
            </a>
            <a href="instructors.php" class="<?= TITLE == 'Instructors' ? 'bg-violet-300' : '' ?> flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14s1.5-2 4-2 4 2 4 2v5H8v-5zm0-6a4 4 0 108 0 4 4 0 00-8 0z" />
                </svg>
                Instructors
            </a>
            <a href="students.php" class="<?= TITLE == 'Students' ? 'bg-violet-300' : '' ?> flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7c2 0 4-2 4-4s-2-4-4-4-4 2-4 4 2 4 4 4zm6 2H6c-2 0-2 2-2 4v5h16v-5c0-2 0-4-2-4z" />
                </svg>
                Students
            </a>
            <a href="feedback.php" class="<?= TITLE == 'Feedbacks' ? 'bg-violet-300' : '' ?> flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M4 10h16M3 16h18" />
                </svg>
                Feedbacks
            </a>
            <!-- Home -->
            <a href="../index.php" class="flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300 <?= TITLE == 'Home' ? 'bg-violet-300' : '' ?>">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M3 12v7h18v-7M9 21v-5h6v5" />
                </svg>
                Home
            </a>
            <a href="../logout.php" class="flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l7-7m0 0l7 7m-7-7v14" />
                </svg>
                Logout
            </a>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="ml-64 mt-16 p-6">
    <!-- Your main content goes here -->