<?php
$testimonials = [];
$testimonial_sql = "SELECT s.name, s.occupation, s.image, f.f_content FROM student AS s JOIN feedback AS f ON s.id = f.stu_id";
$testimonial_sql_result = $conn->query($testimonial_sql);
if ($testimonial_sql_result->num_rows > 0) {
  while ($row = $testimonial_sql_result->fetch_assoc()) {
    $testimonials[] = $row;
  }
}
?>

<!-- Start Students Testimonial -->
<div class="bg-violet-700 overflow-hidden pt-20 mt-10" id="Feedback">
  <h1 class="text-center text-white text-4xl font-extrabold mb-8">Student's Feedback</h1>
  <div class="container mx-auto">
    <div class="swiper-container" id="testimonial-slider">
      <div class="swiper-wrapper">

      <?php foreach ($testimonials as $testimonial) : ?>
        <div class="swiper-slide">
          <div class="bg-white shadow-lg rounded-lg p-6 md:p-8 lg:p-10 mb-4 mx-2 transition-transform transform hover:scale-105 duration-300">
            <div class="flex items-center mb-4">
              <img src="<?= str_replace('../', '', $testimonial['image']) ?>" alt="Student Image" class="w-16 h-16 rounded-full mr-4 shadow-md">
              <div>
                <h4 class="text-lg font-semibold text-gray-800"><?= $testimonial['name'] ?></h4>
                <small class="text-gray-500"><?= $testimonial['occupation'] ?></small>
              </div>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed"><?= $testimonial['f_content'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>

      </div>
      <!-- Add Pagination if needed -->
      <!-- <div class="swiper-pagination"></div> -->
      <!-- Add Navigation if needed -->
      <!-- <div class="swiper-button-next"></div> -->
      <!-- <div class="swiper-button-prev"></div> -->
    </div>
  </div>
</div> 
<!-- End Students Testimonial -->