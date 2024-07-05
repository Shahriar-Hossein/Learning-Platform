<?php

include('./dbConnection.php');
session_start();

if (!isset($_SESSION['stuLogEmail'])) {
  echo "<script> location.href='loginorsignup.php'; </script>";
} else {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stuEmail = $_SESSION['stuLogEmail'];
    $course_id = $_POST['course_id'];
    $order_id = "ORDS" . rand(10000, 99999999);
    $amount = isset($_POST['TXN_AMOUNT']) ? intval($_POST['TXN_AMOUNT']) : 0;
    $camount_query = "SELECT course_price FROM course WHERE course_id = $course_id";
    $camount_result = $conn->query($camount_query);

    if ($camount_result->num_rows > 0) {
      $row = $camount_result->fetch_assoc();
      $course_price = $row['course_price'];
      $sql = "INSERT INTO courseorder (order_id, stu_email, course_id, status, respmsg, amount, order_date) VALUES ('$order_id', '$stuEmail', '$course_id', '', '', '$course_price', CURDATE())";

      if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Going to Payment Gateway');</script>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } else {
      echo "Error: Course not found.";
    }

    $conn->close();
  }

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="GENERATOR" content="Evrsoft First Page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" type="text/css" href="./css/style.css" />

    <title>ELearning</title>
    <title>Checkout</title>
  </head>

  <body>
    <div class="container mt-5">
      <div class="row">
        <div class="col-sm-6 offset-sm-3 jumbotron">
          <h3 class="mb-5">Welcome to E-Learning Payment Page</h3>
          <form method="post" action="payment.php">
            <div class="form-group row">
              <label for="ORDER_ID" class="col-sm-4 col-form-label">Order ID</label>
              <div class="col-sm-8">
                <input id="ORDER_ID" class="form-control" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo  "ORDS" . rand(10000, 99999999) ?>" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="CUST_ID" class="col-sm-4 col-form-label">Student Email</label>
              <div class="col-sm-8">
                <input id="CUST_ID" class="form-control" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="<?php if (isset($stuEmail)) {
                                                                                                                                          echo $stuEmail;
                                                                                                                                        } ?>" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="TXN_AMOUNT" class="col-sm-4 col-form-label">Amount</label>
              <div class="col-sm-8">
                <input title="TXN_AMOUNT" class="form-control" tabindex="10" type="text" name="TXN_AMOUNT" value="<?php if (isset($_POST['id'])) {
                                                                                                                    echo $_POST['id'];
                                                                                                                  } ?>" readonly>
              </div>
            </div>
            <div class="form-group row">
              <!-- <label for="INDUSTRY_TYPE_ID" class="col-sm-4 col-form-label">INDUSTRY TYPE ID</label> -->
              <div class="col-sm-8">
                <input type="hidden" id="INDUSTRY_TYPE_ID" class="form-control" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail" readonly>
              </div>
            </div>
            <div class="form-group row">
              <!-- <label for="CHANNEL_ID" class="col-sm-4 col-form-label">Channel ID</label> -->
              <div class="col-sm-8">
                <input type="hidden" id="CHANNEL_ID" class="form-control" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="COURSE_ID" class="col-sm-4 col-form-label">Course ID</label> <!-- Add this section -->
              <div class="col-sm-8">
                <input id="COURSE_ID" class="form-control" tabindex="2" maxlength="12" size="12" name="COURSE_ID" autocomplete="off" value="<?php if (isset($_POST['course_id'])) {
                                                                                                                                              echo $_POST['course_id'];
                                                                                                                                            } ?>" readonly>
              </div>
            </div>
            <div class="text-center">
              <input value="Check out" type="submit" class="btn btn-primary" onclick="">
              <a href="./courses.php" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
          <small class="form-text text-muted">Note: Complete Payment by Clicking Checkout Button</small>
        </div>
      </div>
    </div>

    <!-- Jquery and Boostrap JavaScript -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <!-- Font Awesome JS -->
    <script type="text/javascript" src="js/all.min.js"></script>

    <!-- Custom JavaScript -->
    <script type="text/javascript" src="js/custom.js"></script>

  </body>

  </html>
<?php } ?>