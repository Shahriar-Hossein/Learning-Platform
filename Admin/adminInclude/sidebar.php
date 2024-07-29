<?php
const DIRECTORY = '../';
include ('../mainInclude/header.php');
?>

 <!-- Top Navbar -->
 <nav class="navbar navbar-dark fixed-top p-0 shadow" style="background-color: #225470;">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="adminDashboard.php">Maria's School <small class="text-white">Admin Area</small></a>
 </nav>

 <!-- Side Bar -->
 <div class="container-fluid mb-5" style="margin-top:40px;">
  <div class="row">
   <nav class="col-sm-3 col-md-2 bg-light sidebar py-5 d-print-none">
    <div class="sidebar-sticky">
     <ul class="nav flex-column">
      <li class="nav-item">
       <a class="nav-link <?= TITLE == 'Dashboard' ? 'active' : '' ?>" href="adminDashboard.php">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link <?= TITLE == 'Courses' ? 'active' : '' ?>" href="courses.php">
        <i class="fab fa-accessible-icon"></i>
        Courses
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link <?= TITLE == 'Lessons' ? 'active' : '' ?>" href="lessons.php">
        <i class="fab fa-accessible-icon"></i>
        Lessons
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link <?= TITLE == 'Students' ? 'active' : '' ?>" href="students.php">
        <i class="fas fa-users"></i>
        Students
       </a>
      </li>
      
      <li class="nav-item">
       <a class="nav-link <?= TITLE == 'Sell Report' ? 'active' : '' ?>" href="sellReport.php">
        <i class="fas fa-table"></i>
        Sell Report
       </a>
      </li>
     
      <li class="nav-item">
       <a class="nav-link <?= TITLE == 'Feedback' ? 'active' : '' ?>" href="feedback.php">
        <i class="fab fa-accessible-icon"></i>
        Feedback
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link <?= TITLE == 'Change Password' ? 'active' : '' ?>" href="adminChangePass.php">
        <i class="fas fa-key"></i>
        Change Password
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link" href="../logout.php">
        <i class="fas fa-sign-out-alt"></i>
        Logout
       </a>
      </li>
     </ul>
    </div>
   </nav>