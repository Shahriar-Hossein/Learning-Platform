<?php
const TITLE = "Maria's School";
const PAGE = "courses";
const DIRECTORY = "";

include('./dbConnection.php');
session_start();

// Fetch search parameters
$searchCourseName = $_GET['course_name'] ?? '';
$searchPrice = $_GET['price'] ?? '';

// Build query with filters
$query = "SELECT *, COALESCE(rating, 0) AS rating, COALESCE(total_reviews, 0) AS total_reviews FROM course WHERE 1=1";

if (!empty($searchCourseName)) {
    $query .= " AND course_name LIKE '%" . $conn->real_escape_string($searchCourseName) . "%'";
}
if (!empty($searchPrice)) {
    $query .= " AND course_price <= " . intval($searchPrice);
}

$query .= " ORDER BY rating DESC";
$courses = [];
$course_sql_result = $conn->query($query);
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

<!-- Filtering Section -->
<div class="container mx-auto mt-6 px-6">
    <form method="GET" class="bg-white shadow-md rounded p-6 flex flex-wrap gap-4 items-center">
        <div class="w-full md:w-1/3">
            <label for="course_name" class="block text-sm font-medium text-gray-700">Course Name</label>
            <input type="text" name="course_name" id="course_name" 
                   value="<?= htmlspecialchars($searchCourseName) ?>" 
                   class="border-gray-300 rounded px-3 py-2 w-full" 
                   placeholder="Enter course name">
        </div>
        <div class="w-full md:w-1/3">
            <label for="price" class="block text-sm font-medium text-gray-700">Max Price (৳)</label>
            <input type="number" name="price" id="price" 
                   value="<?= htmlspecialchars($searchPrice) ?>" 
                   class="border-gray-300 rounded px-3 py-2 w-full" 
                   placeholder="Enter max price">
        </div>
        <button type="submit" class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
            Search
        </button>
        <a href="courses.php" class="text-violet-600 hover:underline">Reset Filters</a>
    </form>
</div>

<!-- Course List -->
<div class="container mx-auto mt-8">
    <h1 class="text-center text-4xl font-bold mb-8 text-violet-600">All Courses</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
    <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <a href="coursedetails.php?course_id=<?= $course['course_id'] ?>" class="block">
                    <img src="<?= str_replace('..', '.', $course['course_img']) ?>" alt="Course Image" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h5 class="text-lg font-semibold mb-2"><?= $course['course_name'] ?></h5>
                        <!-- Display Rating as Stars -->
                        <div class="flex items-center">
                            <?php
                            $rating = round($course['rating'], 1);
                            $fullStars = floor($rating);
                            $halfStar = $rating - $fullStars >= 0.5;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '<i class="fas fa-star text-yellow-500"></i>';
                            }
                            if ($halfStar) {
                                echo '<i class="fas fa-star-half-alt text-yellow-500"></i>';
                            }
                            for ($i = 0; $i < $emptyStars; $i++) {
                                echo '<i class="far fa-star text-yellow-500"></i>';
                            }
                            ?>
                            <span class="ml-2 text-sm text-gray-600">(<?= $course['total_reviews'] ?>)</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-100">
                        <p class="text-gray-800">Price: 
                        <span class="text-lg font-bold text-violet-600">৳ <?= $course['course_price'] ?></span></p>
                        <span class="bg-violet-600 text-white px-4 py-2 rounded-md hover:bg-violet-700">View</span>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center text-gray-600 text-lg">No courses found. Try adjusting the filters.</p>
    <?php endif; ?>

    </div>
</div>

<?php include(DIRECTORY . 'mainInclude/footer.php'); ?>
