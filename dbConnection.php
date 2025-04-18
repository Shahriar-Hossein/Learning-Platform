<?php
// for windows with laragon
// $db_host = "localhost";

// for ubuntu
$db_host = "127.0.0.1";
$db_user = "root";
$db_password = "root";
$db_name = "lms_db";

// Create Connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check Connection
if($conn->connect_error) {
 die("connection failed");
} 
// else {
//  echo"connected";
// }
