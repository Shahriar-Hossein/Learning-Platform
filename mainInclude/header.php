<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

    <!-- Student Testimonial Owl Slider CSS -->
    <link rel="stylesheet" type="text/css" href="css/owl.min.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.min.css">
    <link rel="stylesheet" type="text/css" href="css/testyslider.css">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <title>Elearning</title>

      <style>
          .navbar-nav-center {
              position: absolute;
              left: 50%;
              transform: translateX(-50%);
          }
      </style>
  </head>
  <body>
  <!-- Start Navigation -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
          <!-- Company name -->
          <a href="index.php" class="navbar-brand d-flex flex-column">
              <span style="font-size: 1.5rem;">Maria's School</span>
              <span style="font-size: 0.7rem;">Learn and Grow</span>
          </a>

          <!-- Toggle button for mobile view -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Navbar links -->
          <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
              <ul class="navbar-nav navbar-nav-center">
                  <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                  <li class="nav-item"><a href="courses.php" class="nav-link">Courses</a></li>
                  <li class="nav-item"><a href="#Feedback" class="nav-link">Feedback</a></li>
                  <li class="nav-item"><a href="#Contact" class="nav-link">Contact</a></li>
              </ul>
          </div>

          <!-- Authentication links -->
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
              <ul class="navbar-nav">
                  <?php
                  session_start();
                  if (isset($_SESSION['is_login'])) {
                      echo '<li class="nav-item"><a href="student/studentProfile.php" class="nav-link">My Profile</a></li>';
                      echo '<li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>';
                  } else {
                      echo '<li class="nav-item"><a href="#login" class="nav-link" data-toggle="modal" data-target="#stuLoginModalCenter">Login</a></li>';
                      echo '<li class="nav-item"><a href="#signup" class="nav-link" data-toggle="modal" data-target="#stuRegModalCenter">Signup</a></li>';
                  }
                  ?>
              </ul>
          </div>
      </div>
  </nav>
  <!-- End Navigation -->


