<?php
const DIRECTORY = '../';
include('../mainInclude/header.php');
?>

<!-- Navbar -->
<nav class="bg-violet-500 text-white fixed top-0 w-full z-20 shadow-lg">
    <div class="flex items-center justify-between p-4">
        <!-- Company Logo -->
        <div class="flex items-center">
            <h1 class="flex items-center text-xl font-extrabold text-violet-100 space-x-2">
                <!-- Logo Icon -->
                <svg class="w-8 h-8 text-violet-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4l2 2" />
                </svg>
                <!-- Text -->
                <span>Maria's School</span>
            </h1>
            <!-- Subtitle -->
            <p class="text-sm text-violet-300 ml-4">Instructors Panel</p>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div id="sidebar" class="w-64 bg-violet-400 border-r border-violet-600 text-white fixed h-full top-16 z-10 shadow-md">
    <div class="p-4">
        <nav class="space-y-2">
            <a href="dashboard.php" class="flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300 <?= TITLE == 'Dashboard' ? 'bg-violet-300' : '' ?>">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18" />
                </svg>
                Dashboard
            </a>
            <a href="courses.php" class="flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300 <?= TITLE == 'Courses' ? 'bg-violet-300' : '' ?>">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6M15 8v8M3 12h18" />
                </svg>
                Courses
            </a>
            <a href="add-course.php" class="flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300 <?= TITLE == 'Add Course' ? 'bg-violet-300' : '' ?>">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Course
            </a>
            <a href="lessons.php" class="flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300 <?= TITLE == 'Lessons' ? 'bg-violet-300' : '' ?>">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16m-7 4h7" />
                </svg>
                Lessons
            </a>
            <a href="quiz.php" class="flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300 <?= TITLE == 'Quizes' ? 'bg-violet-300' : '' ?>">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8M8 11h8m-8 4h6" />
                </svg>
                Quizzes
            </a>
            <a href="../logout.php" class="flex items-center py-2.5 px-4 rounded-lg transition duration-150 hover:bg-violet-300">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h7m-7-4l4 4-4 4M4 4v16" />
                </svg>
                Logout
            </a>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="ml-64 mt-16 p-6">
    <!-- Your main content goes here -->

