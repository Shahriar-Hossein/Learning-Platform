<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'Add Course');
define('PAGE', 'addorder');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

 if(isset($_SESSION['is_admin_login'])){
  $adminEmail = $_SESSION['adminLogEmail'];
 } else {
  echo "<script> location.href='../index.php'; </script>";
 }
 if(isset($_REQUEST['courseSubmitBtn'])){
  // Checking for Empty Fields
  if( ($_REQUEST['stu_email'] == "") || ($_REQUEST['STATUS'] == "") || ($_REQUEST['course_id'] == "") ){
   // msg displayed if required field missing
   $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {
   // Assigning User Values to Variable
   
			$stu_email = $_SESSION['stuLogEmail'];
			$course_id = $_SESSION['course_id'];
			$status = $_POST['STATUS'];
   
			$sql = "INSERT INTO courseorder( stu_email, course_id, status) VALUES ( '$stu_email', '$course_id')";
    if($conn->query($sql) == TRUE){
     // below msg display on form submit success
     $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Course Added Successfully </div>';
    } else {
     // below msg display on form submit failed
     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Add Course </div>';
    }
  }
  }
 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Add New Course</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
     
    <div class="form-group">
      <label for="stu_email">Course Description</label>
      <textarea class="form-control" id="stu_email" name="stu-email" row=2></textarea>
    </div>
    <div class="form-group">
      <label for="course_id">Course id</label>
      <input type="text" class="form-control" id="course_author" name="course_author">
    </div>
    
    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="courseSubmitBtn" name="courseSubmitBtn">Submit</button>
      <a href="courses.php" class="btn btn-secondary">Close</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>
<!-- Only Number for input fields -->
<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }
</script>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->

<?php
include('./adminInclude/footer.php'); 
?>