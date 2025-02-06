<?php

const TITLE = "Maria's School";
const PAGE = "Maria's School";
const DIRECTORY = "";

include('./dbConnection.php');

// Fetch courses and handle null ratings
$courses = [];
$course_sql = "SELECT *, COALESCE(rating, 0) AS rating, COALESCE(total_reviews, 0) AS total_reviews FROM course ORDER BY rating DESC"; // Replace NULL ratings with 0
$course_sql_result = $conn->query($course_sql);
if ($course_sql_result->num_rows > 0) {
    while ($row = $course_sql_result->fetch_assoc()) {
        $courses[] = $row;
    }
}

include(DIRECTORY . 'mainInclude/navbar.php');
?>

<div class="bg-violet-300">
  <!-- Start Course Page Banner -->
  <div class="relative">
    <img src="./image/coursebanner.jpg" alt="courses" class="w-full h-[500px] object-cover shadow-md">
  </div>
  <!-- End Course Page Banner -->
</div>

<div class="container mx-auto mt-8">
  <h1 class="text-center text-4xl font-bold mb-8 text-violet-600">Popular Courses</h1>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    
  <?php foreach ($courses as $course): ?>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <a href="coursedetails.php?course_id=<?= $course['course_id'] ?>" class="block">
        <img src="<?= str_replace('..', '.', $course['course_img']) ?>" alt="Course Image" class="w-full h-48 object-cover">
        <div class="p-4">
          <h5 class="text-lg font-semibold mb-2"><?= $course['course_name'] ?></h5>
          <!-- Display Rating as Stars -->
          <div class="flex items-center">
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
        <div class="flex justify-between items-center p-4 bg-gray-100">
          <p class="text-gray-800">Price: <small class="line-through text-gray-600">৳ <?= $course['course_original_price'] ?></small> <span class="font-bold text-violet-600">৳ <?= $course['course_price'] ?></span></p>
          <span class="bg-violet-600 text-white px-4 py-2 rounded-md hover:bg-violet-700">Enroll</span>
        </div>
      </a>
    </div>
  <?php endforeach; ?>

  </div>
</div>

<?php
// Contact Us
include(DIRECTORY . 'components/contact.php');
?>

<?php
// Footer Include from mainInclude
include(DIRECTORY . 'mainInclude/footer.php');
?>
