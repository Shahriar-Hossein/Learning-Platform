<?php
  include('./dbConnection.php');
  // Header Include from mainInclude 
  include('./mainInclude/header.php');
  
?>  
    <div class="container-fluid bg-dark"> <!-- Start Course Page Banner -->
      <div class="row">
        <img src="./image/coursebanner.jpg" alt="courses" style="height:500px; width:100%; object-fit:cover; box-shadow:10px;"/>
      </div> 
    </div> <!-- End Course Page Banner -->

<div class="container mt-5">
    <h1 class="text-center mb-4">Popular Courses</h1>
    <div class="row">
        <?php
        $sql = "SELECT * FROM course";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $course_id = $row['course_id'];
                echo '
              <div class="col-md-4 mb-4">
                <a href="coursedetails.php?course_id='.$course_id.'" class="text-decoration-none text-dark">
                  <div class="card h-100">
                    <img src="'.str_replace('..', '.', $row['course_img']).'" class="card-img-top" alt="Course Image" />
                    <div class="card-body">
                      <h5 class="card-title">'.$row['course_name'].'</h5>
                    </div>
                    <div class="card-footer">
                      <p class="card-text d-inline">Price: <small><del>&#2547; '.$row['course_original_price'].'</del></small> <span class="font-weight-bolder">&#2547; '.$row['course_price'].'</span></p>
                      <span class="btn btn-primary text-white">Enroll</span>
                    </div>
                  </div>
                </a>
              </div>';
            }
        }
        ?>
    </div>
</div>

<?php 
  // Contact Us
  include('./contact.php'); 
?> 

<?php 
  // Footer Include from mainInclude 
  include('./mainInclude/footer.php'); 
?>  

<style>
    .card img {
        object-fit: cover;
        height: 200px;
    }
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-footer p {
        margin: 0;
    }
    .card-footer .btn {
        padding: 0.375rem 0.75rem;
    }
    .card a {
        text-decoration: none;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: scale(1.02);
    }
</style>