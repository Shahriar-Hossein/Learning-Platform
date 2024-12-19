<?php
include('./dbConnection.php');

const TITLE = "Maria's School";
const PAGE = "Maria's School";
const DIRECTORY = "";

include(DIRECTORY . 'mainInclude/navbar.php');
?>

<div class="bg-violet-300">
  <!-- Start Course Page Banner -->
  <div class="relative">
    <img src="./image/coursebanner.jpg" alt="courses" class="w-full h-[200px] object-cover shadow-md">
  </div>
  <!-- End Course Page Banner -->
</div>

<div class="container mx-auto mt-8"> <!-- Start All Course -->
  <?php
  if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $_SESSION['course_id'] = $course_id;
    $sql = "SELECT * FROM course WHERE course_id = '$course_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo ' 
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                  <div class="lg:col-span-1">
                    <img src="' . str_replace('..', '.', $row['course_img']) . '" alt="Course Image" class="rounded-lg shadow-md w-full h-auto" />
                  </div>
                  <div class="lg:col-span-2">
                    <div class="p-4">
                      <h5 class="text-3xl font-bold text-violet-600 mb-4">Course Name: ' . $row['course_name'] . '</h5>
                      <p class="text-gray-700 mb-4">Duration: ' . $row['course_duration'] . '</p>
                      <p class="text-gray-800 text-lg mb-4">Price: <small class="line-through text-gray-600">৳ ' . $row['course_original_price'] . '</small> <span class="font-bold text-violet-600">৳ ' . $row['course_price'] . '</span></p>

                      <form action="checkout.php" method="post">
                        <input type="hidden" name="id" value="' . $row['course_price'] . '">
                        <input type="hidden" name="course_id" value="' . $row['course_id'] . '">
                        <button type="submit" class="bg-violet-600 text-white px-6 py-2 rounded-md hover:bg-violet-700">Buy Now</button>
                      </form>
                    </div>
                  </div>
                </div>';
      }
    }
  }
  ?>
</div> <!-- End All Course -->

<div class="container mx-auto mt-8">
  <h2 class="text-2xl font-semibold text-violet-600 mb-4">Lessons</h2>
  <div class="overflow-x-auto">
    <?php 
    $sql = "SELECT * FROM lesson WHERE course_id = '$course_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      echo '<table class="min-w-full table-auto border border-gray-300 rounded-lg">
             <thead>
               <tr class="bg-violet-100 text-left">
                 <th class="px-4 py-2 border-b border-gray-300">Lesson No.</th>
                 <th class="px-4 py-2 border-b border-gray-300">Lesson Name</th>
               </tr>
             </thead>
             <tbody>';
      $num = 0;
      while ($row = $result->fetch_assoc()) {
          $num++;
          echo '<tr class="border-t border-gray-200">
                  <td class="px-4 py-2">' . $num . '</td>
                  <td class="px-4 py-2">' . $row["lesson_name"] . '</td>
                </tr>';
      }
      echo '</tbody>
           </table>';
    } else {
      echo '<p class="text-gray-700">No lessons available for this course.</p>';
    }
    ?>
  </div>
</div>

<?php 
// Footer Section
include(DIRECTORY . 'mainInclude/footer.php'); 
?>
