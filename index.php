<?php
include('./dbConnection.php');

// Fetch courses sorted by rating
$courses = [];
$course_sql = "SELECT *, COALESCE(rating, 0) AS rating, COALESCE(total_reviews, 0) AS total_reviews FROM course ORDER BY rating DESC LIMIT 6";
$course_sql_result = $conn->query($course_sql);
if ($course_sql_result->num_rows > 0) {
    while ($row = $course_sql_result->fetch_assoc()) {
        $courses[] = $row;
    }
}

const TITLE = "Maria's School";
const PAGE = "Maria's School";
const DIRECTORY = "";

include(DIRECTORY . 'mainInclude/navbar.php');
?>

<div class="relative main-banner">
  <img src="image/banner.jpg" class="w-full h-96 object-cover" alt="Website Banner">
  <div class="absolute inset-0 flex flex-col items-center justify-center bg-violet-300 bg-opacity-50 text-white">
    <h1 class="text-5xl font-bold">Maria's School</h1>
    <small class="text-xl mt-2">Learn and Grow</small><br />
    <?php if (!isset($_SESSION['is_login'])): ?>
      <a class="bg-violet-600 hover:bg-violet-700 text-white py-2 px-4 rounded mt-3" href="#" data-toggle="modal" data-target="#stuRegModalCenter">Get Started</a>
    <?php else: ?>
      <a class="bg-violet-600 hover:bg-violet-700 text-white py-2 px-4 rounded mt-3" href="Student/studentProfile.php">My Profile</a>
    <?php endif; ?>
  </div>
</div>

<!-- Start Text Banner -->
<div class="bg-violet-700 text-white py-3"> 
  <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
    <div>
      <h5 class="flex items-center justify-center"><i class="fas fa-book-open mr-3"></i>100+ Online Courses</h5>
    </div>
    <div>
      <h5 class="flex items-center justify-center"><i class="fas fa-users mr-3"></i>Expert Instructors</h5>
    </div>
    <div>
      <h5 class="flex items-center justify-center"><i class="fas fa-keyboard mr-3"></i>Lifetime Access</h5>
    </div>
    <div>
      <h5 class="flex items-center justify-center">&#2547; Money Back Guarantee*</h5>
    </div>
  </div>
</div>
<!-- End Text Banner -->

<div class="container mx-auto mt-10">
  <h2 class="text-center text-4xl font-extrabold text-violet-700 mb-8">Popular Courses</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mx-2">
    
    <?php foreach ($courses as $course): ?>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <a href="<?= 'coursedetails.php?course_id=' . $course['course_id'] ?>" class="text-gray-900 no-underline">
        <img src="<?= str_replace('..', '.', $course['course_img']) ?>" class="w-full h-48 object-cover" alt="Course Image">
        <div class="p-4">
          <h5 class="font-bold text-lg"><?= $course['course_name'] ?></h5>
          <!-- Display Rating as Stars -->
          <div class="flex items-center mt-2">
            <?php
            $rating = round($course['rating'], 1); // Round the rating to 1 decimal
            $fullStars = floor($rating);
            $halfStar = $rating - $fullStars >= 0.5 ? true : false;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            
            // Full stars
            for ($i = 0; $i < $fullStars; $i++) {
                echo '<i class="fas fa-star text-yellow-500"></i>';
            }
            // Half star
            if ($halfStar) {
                echo '<i class="fas fa-star-half-alt text-yellow-500"></i>';
            }
            // Empty stars
            for ($i = 0; $i < $emptyStars; $i++) {
                echo '<i class="far fa-star text-yellow-500"></i>';
            }
            ?>
            <span class="ml-2 text-sm text-gray-600">(<?= $course['total_reviews'] ?>)</span>
          </div>
        </div>
        <div class="p-4 bg-gray-100">
          <p class="text-sm">Price: <small class="line-through">&#2547; <?= $course['course_original_price'] ?></small> <span class="text-lg font-bold">&#2547; <?= $course['course_price'] ?></span></p>
          <span class="inline-block bg-violet-600 hover:bg-violet-700 text-white py-1 px-3 rounded mt-2">Enroll</span>
        </div>
      </a>
    </div>
    <?php endforeach; ?>

  </div>
  
  <div class="text-center m-2 mt-6">
    <a class="bg-violet-600 hover:bg-violet-700 text-white py-2 px-4 rounded" href="courses.php">View All Courses</a>
  </div>
</div>

<?php
// Contact Us
include('components/contact.php');

include('components/testimonials.php');
?>

<!-- Start Social Follow -->
<div class="bg-violet-700 text-white py-2">
  <div class="container mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
    <div>
      <a class="hover:text-violet-300" href="#"><i class="fab fa-facebook-f mr-2"></i> Facebook</a>
    </div>
    <div>
      <a class="hover:text-violet-300" href="#"><i class="fab fa-twitter mr-2"></i> Twitter</a>
    </div>
    <div>
      <a class="hover:text-violet-300" href="#"><i class="fab fa-whatsapp mr-2"></i> WhatsApp</a>
    </div>
    <div>
      <a class="hover:text-violet-300" href="#"><i class="fab fa-instagram mr-2"></i> Instagram</a>
    </div>
  </div>
</div>
<!-- End Social Follow -->

<!-- Start About Section -->
<div class="bg-gray-100 py-8">
  <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
    <div>
      <h5 class="text-2xl font-extrabold text-violet-700 mb-4">About Us</h5>
      <p class="text-gray-700">Maria's School provides universal access to the world’s best education, partnering with top universities and organizations to offer courses online.</p>
    </div>
    <div>
      <h5 class="text-2xl font-extrabold text-violet-700 mb-4">Category</h5>
      <a class="text-gray-700 hover:text-violet-600" href="#">Web Development</a><br />
      <a class="text-gray-700 hover:text-violet-600" href="#">Web Designing</a><br />
      <a class="text-gray-700 hover:text-violet-600" href="#">Android App Dev</a><br />
      <a class="text-gray-700 hover:text-violet-600" href="#">iOS Development</a><br />
      <a class="text-gray-700 hover:text-violet-600" href="#">Data Analysis</a><br />
    </div>
    <div>
      <h5 class="text-2xl font-extrabold text-violet-700 mb-4">Contact Us</h5>
      <p class="text-gray-700">Maria's School Pvt Ltd <br> Near Police Camp <br> Mirpur-Shewrapara, Dhaka</p>
    </div>
  </div>
</div>
<!-- End About Section -->

<?php
// Footer Include from mainInclude
include('mainInclude/footer.php');
?>
