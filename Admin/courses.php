<?php
if(!isset($_SESSION)){
    session_start();
}
include '../dbConnection.php';

if(! isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php"); 
}

$courses = [];
$sql = "SELECT * FROM course";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $courses[] = $row;
    }
}

const TITLE = 'Courses';
const PAGE = 'courses';
const DIRECTORY = '../';

include 'include/sidebar.php';
?>

<div class="my-2 py-2 bg-violet-400 text-white shadow-lg rounded-lg">
    <h3 class="text-center text-4xl font-extrabold my-2">Courses</h3>
    <p class="text-center text-lg text-gray-600 mb-2">This is the list of all the courses available on the site.</p>
</div>

<!--        <button onclick="toggleSidebar()" class="lg:hidden bg-blue-500 text-white px-4 py-2 rounded mb-4">Toggle Sidebar</button>-->

<div class="flex justify-center">
  <div class="w-full bg-white shadow-lg rounded-lg overflow-auto">
    <table class="min-w-full leading-normal overflow-auto min-w-[500px]">
      <thead>
        <tr>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">SL NO.</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Name</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Duration</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Original Price</th>
          <th class="py-5 px-7 bg-violet-200 text-left text-xs font-semibold text-violet-600 uppercase tracking-wider">Course Price</th>
        </tr>
      </thead>
      <tbody>

      <!--               PHP If table is empty    -->
      <?php if (empty($courses)): ?>
        <tr>
          <td colspan="6" class="text-center py-4">No courses found</td>
        </tr>
      <?php endif; ?>
      <!--               PHP END IF   -->

      <!--                PHP LOOP START      -->
      <?php foreach ($courses as $index => $course): ?>
          <tr class="border-b border-violet-200 hover:bg-violet-50 transition duration-150 ease-in-out">
              <td class="py-4 px-4 text-sm"><?= $index + 1 ?></td>
              <td class="py-4 px-4 text-sm"><?= $course["course_name"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $course["course_duration"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $course["course_price"] ?></td>
              <td class="py-4 px-4 text-sm"><?= $course["course_original_price"] ?></td>
          </tr>
      <?php endforeach; ?>
      <!--                PHP LOOP END        -->
      </tbody>
    </table>
  </div>
</div>


<!--    <div><a class="btn btn-danger box" href="./addCourse.php"><i class="fas fa-plus fa-2x"></i></a></div>-->
<?php
include '../mainInclude/footer.php';
?>