<?php
include('./dbConnection.php');
session_start();
const TITLE = "Maria's School";
const PAGE = "payment_failed_page";
const DIRECTORY = "";

if (!isset($_SESSION['failed_page_refreshed'])) {
    // Get course_order_id safely
    $course_order_id = isset($_GET['course_order_id']) ? intval($_GET['course_order_id']) : null;

    if ($course_order_id) {
        // Update the status field to 'TXN_FAILED'
        $update_sql = "UPDATE courseorder SET status = 'TXN_FAILED' WHERE co_id = ?";
        
        // Use prepared statement
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $course_order_id);
        $stmt->execute();
        $stmt->close();
    }

    // Mark that this page has been loaded once
    $_SESSION['failed_page_refreshed'] = true;

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
    <title>Payment Failed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Notyf CSS -->
    <link href="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg text-center">
        <div class="flex justify-center items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5a1 1 0 012 0v2a1 1 0 01-2 0v-2zm0-8a1 1 0 011 1v4a1 1 0 01-2 0V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Payment Failed</h1>
        <p class="text-gray-600 text-lg mb-6">
            Sorry! Your payment was not successful. Please try again or contact support.
        </p>
        <div class="flex flex-col gap-4">
            <a href="coursedetails.php?course_id=<?= $_GET['course_id'] ?>" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg shadow-md text-lg font-semibold">
                Retry Payment
            </a>
            <a href="index.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg shadow-md text-lg font-semibold">
                Return to Home
            </a>
        </div>
    </div>

    <script>
        // Initialize Notyf
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            duration: 5000, 
            ripple: true 
        });

        // Show failure notification
        window.onload = function() {
            notyf.error("Payment Failed! Please try again.");
        };
    </script>
</body>
</html>
