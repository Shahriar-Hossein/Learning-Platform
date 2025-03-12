<?php
session_start(); // Start session
include('./dbConnection.php');

const TITLE = "Maria's School";
const PAGE = "Maria's School";
const DIRECTORY = "";
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $_SESSION['course_id'] = $course_id;

    // Fetch course details
    $sql = "SELECT * FROM course WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    $stmt->close();

    // Fetch lessons
    $sql = "SELECT * FROM lesson WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $lessons = [];
    while ($row = $result->fetch_assoc()) {
        $lessons[] = $row;
    }
    $stmt->close();

    // Check if the user is logged in and has purchased the course
    $is_logged_in = isset($_SESSION['student_id']);
    $has_purchased = false;

    if ($is_logged_in) {
        $student_email = $_SESSION['student_email']; // Use email instead of ID
        $sql = "SELECT * FROM courseorder WHERE stu_email = ? AND course_id = ? AND status = 'TXN_SUCCESS'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $student_email, $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $has_purchased = ($result->num_rows > 0);
        $stmt->close();
    }

    // Fetch ratings and calculate average
    $ratings = [];
    $average_rating = 0;

    $sql = "SELECT cr.rating, cr.review, s.name, s.image 
            FROM course_rating cr 
            LEFT JOIN student s ON cr.student_id = s.id 
            WHERE cr.course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_rating = 0;
    $rating_count = 0;
    while ($row = $result->fetch_assoc()) {
        // Handle missing student details
        if (empty($row['name'])) {
            $row['name'] = "Anonymous User";
        }
        if (empty($row['image'])) {
            $row['image'] = "./image/default_image3.jpg"; // Default avatar
        }

        $ratings[] = $row;
        $total_rating += $row['rating'];
        $rating_count++;
    }
    $stmt->close();

    if ($rating_count > 0) {
        $average_rating = round($total_rating / $rating_count, 1);
    }

    
} else {
  header('location: courses.php');
}

include(DIRECTORY . 'mainInclude/navbar.php');
?>

<div class="bg-violet-300">
  <div class="relative">
    <img src="./image/coursebanner.jpg" alt="courses" class="w-full h-[200px] object-cover shadow-md">
  </div>
</div>

<div class="container mx-auto mt-8"> 
  <?php if(isset($course) && !empty($course)) : ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-1">
        <img src="<?= str_replace('..', '.', $course['course_img']) ?>" alt="Course Image" class="rounded-lg shadow-md w-full h-auto" />
      </div>
      <div class="lg:col-span-2">
        <div class="p-4">
          <h5 class="text-3xl font-bold text-violet-600 mb-4">Course Name: <?= htmlspecialchars($course['course_name']) ?> </h5>
          <p class="text-gray-700 mb-4">Duration: <?= htmlspecialchars($course['course_duration']) ?> Days </p>
          <p class="text-gray-800 text-lg mb-4">Price: 
            <span class="font-bold text-violet-600">৳ <?= htmlspecialchars($course['course_price']) ?></span>
          </p>
          
          <?php if($is_logged_in) : ?>
            <?php if($has_purchased) : ?>
              <a href="Student/view-course.php?course_id=<?= urlencode($course_id); ?>" class="bg-violet-600 text-white px-6 py-2 rounded-md hover:bg-violet-700">
                View Course
              </a>
            <?php else : ?>
              <form action="checkout.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($course['course_price']) ?>">
                <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['course_id']) ?>">
                <button type="submit" class="bg-violet-600 text-white px-6 py-2 rounded-md hover:bg-violet-700">Buy Now</button>
              </form>
            <?php endif; ?>
          <?php else : ?>
            <p class="text-red-500">Please log in as student to purchase this course.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php else : ?>
    <p class="text-red-500 text-center">Course not found.</p>
  <?php endif; ?>
</div> 

<div class="container mx-auto mt-8">
  <h2 class="text-2xl font-semibold text-violet-600 mb-4">Lessons</h2>
  <div class="overflow-x-auto">
    <table class="min-w-full table-auto border border-gray-300 rounded-lg">
      <thead>
        <tr class="bg-violet-100 text-left">
          <th class="px-4 py-2 border-b border-gray-300">Lesson No.</th>
          <th class="px-4 py-2 border-b border-gray-300">Lesson Name</th>
        </tr>
      </thead>
      <tbody>
      <?php if(!empty($lessons)) : ?>
        <?php foreach($lessons as $index => $lesson) : ?>
          <tr class="border-t border-gray-200">
            <td class="px-4 py-2"><?= $index +1  ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($lesson["lesson_name"]) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="2" class="px-4 py-2 text-center">No lessons available for this course.</td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Ratings Section -->
<div class="container mx-auto mt-8">
  <h2 class="text-2xl font-semibold text-violet-600 mb-4">Course Ratings & Reviews</h2>
  
  <!-- Average Rating -->
  <div class="text-lg font-semibold text-gray-800">
    Average Rating: <span class="text-violet-600"><?= $average_rating ?> ★</span> (<?= $rating_count ?> reviews)
  </div>

  <div class="mt-4">
    <?php if (!empty($ratings)) : ?>
      <?php foreach ($ratings as $rating) : ?>
        <div class="bg-white p-4 rounded-lg shadow-md mb-4 flex items-center">
          <img src="<?= str_replace('..', '.', $rating['image']) ?>" alt="Student Image" class="w-12 h-12 rounded-full mr-4">
          <div>
            <h4 class="text-lg font-bold"><?= htmlspecialchars($rating['name']) ?></h4>
            <div class="text-yellow-500">
              <?= str_repeat('★', $rating['rating']) . str_repeat('☆', 5 - $rating['rating']) ?>
            </div>
            <?php if (!empty($rating['review'])) : ?>
              <p class="text-gray-600 mt-2"><?= htmlspecialchars($rating['review']) ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-gray-600">No ratings or reviews yet.</p>
    <?php endif; ?>
  </div>
</div>

<?php 
include(DIRECTORY . 'mainInclude/footer.php'); 
?>
