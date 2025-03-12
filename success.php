<?php
include('./dbConnection.php');
session_start();
const TITLE = "Maria's School";
const PAGE = "payment_success_page";
const DIRECTORY = "";

if (!isset($_SESSION['success_page_refreshed'])) {
    // get from query params
    $course_order_id = $_GET['course_order_id'];
    // Update the status field to 'TXN_SUCCESS'
    $update_sql = "UPDATE courseorder SET status = 'TXN_SUCCESS' WHERE co_id = {$course_order_id}";
    
    // Execute the update query
    if ($conn->query($update_sql) === TRUE) {
        // echo "Status updated successfully!";
    } else {
        // echo "Error updating status: " . $conn->error;
    }
    // Mark that this page has been loaded once
    $_SESSION['success_page_refreshed'] = true;
    
    $_SESSION['student_id'] = $_GET['user_id'];
    $_SESSION['student_email'] = $_GET['user_email'];
    $_SESSION['role'] = "student";
    $_SESSION['is_login'] = true;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Notyf CSS -->
    <link href="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg text-center">
        <div class="flex justify-center items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 10-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Payment Successful!</h1>
        <p class="text-gray-600 text-lg mb-6">
            Thank you for your payment! Your transaction has been completed successfully.
        </p>
        <div class="flex flex-col gap-4">
            <a href="Student/my-courses.php" class="bg-violet-500 hover:bg-violet-600 text-white px-6 py-3 rounded-lg shadow-md text-lg font-semibold">
                Access Your Courses
            </a>
            <a href="index.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg shadow-md text-lg font-semibold">
                Return to Home
            </a>
        </div>
    </div>

    <script>
        // Initialize Notyf with custom position
        const notyf = new Notyf({
            position: {
                x: 'right', // Align to the right
                y: 'top'    // Align to the top
            },
            duration: 5000, // Toast visibility duration
            ripple: true     // Optional: add ripple effect to the toast
        });

        // Show the toast notification when the page loads
        window.onload = function() {
            // Show the success toast at the top-right corner
            notyf.success("Congratulations! New course added!");
        };
    </script>
</body>
</html>
