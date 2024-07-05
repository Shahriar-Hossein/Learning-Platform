<?php
// Include necessary files
include 'dbConnection.php';
require __DIR__ . "/vendor/autoload.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// SSLCommerz Configuration
$store_id = "zante65e3a05559d46"; // Replace with your actual store ID
$store_passwd = "zante65e3a05559d46@ssl"; // Replace with your actual store password
$success_url = "http://localhost/lms/success.php";
$fail_url = "http://localhost/lms/index.php";
$cancel_url = "http://localhost/lms/index.php";
$currency = "BDT";

// Retrieve form data
$order_id = $_POST['ORDER_ID'];
$customer_email = $_POST['CUST_ID'];
$total_amount = $_POST['TXN_AMOUNT'];

// Transaction ID
$transaction_id = uniqid(); // Unique transaction ID

// Product Information
$product_name = "E-Learning Course"; // Example product name
$shipping_method = "NO"; // Example shipping method

// Create Payment Request
$post_data = array(
    'store_id' => $store_id,
    'store_passwd' => $store_passwd,
    'total_amount' => $total_amount,
    'currency' => $currency,
    'tran_id' => $transaction_id,
    'success_url' => $success_url,
    'fail_url' => $fail_url,
    'cancel_url' => $cancel_url,
    'cus_name' => $customer_email, // Replace with actual customer name
    'cus_email' => $customer_email,
    'cus_city' => "Dhaka", // Default customer city
    'cus_state' => "Dhaka", // Default customer state
    'cus_postcode' => "1000", // Default customer postcode
    'cus_country' => "Bangladesh", // Default customer country
    'cus_add1' => "Dhaka", // Replace with actual customer address
    'cus_phone' => "01711111111", // Replace with actual customer phone number
    'shipping_method' => $shipping_method,
    'product_name' => $product_name,
    'product_category' => 'Product',
    'product_profile' => 'general', // Added product profile
);

// Make API request to SSLCommerz
$direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php"; // Use sandbox URL for testing
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $direct_api_url);
curl_setopt($handle, CURLOPT_TIMEOUT, 30);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($handle, CURLOPT_POST, 1);
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$content = curl_exec($handle);

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if ($code == 200 && !(curl_errno($handle))) {
    curl_close($handle);
    $sslcommerzResponse = json_decode($content, true);

    if (isset($sslcommerzResponse['GatewayPageURL']) && $sslcommerzResponse['GatewayPageURL'] != "") {
        // Redirect to SSLCommerz payment page
        header("Location: " . $sslcommerzResponse['GatewayPageURL']);
        exit;
    } else {
        echo "JSON Data parsing error! Response: " . htmlspecialchars($content);
    }
} else {
    curl_close($handle);
    echo "Failed to connect with SSLCommerz API. HTTP Status Code: $code. Response: " . htmlspecialchars($content);
}

// Insert order details into the database after successful payment
if ($code == 200 && !(curl_errno($handle))) {
    // Update courseorder table
    $sql = "INSERT INTO courseorder (order_id, stu_email, course_id, status, respmsg, amount, order_date) 
            VALUES ('$order_id', '$customer_email', {$_SESSION['course_id']}, 'TXN_SUCCESS', 'Txn Success', $total_amount, CURDATE())";
    $result = $conn->query($sql);

    if ($result) {
        // Redirect to success page
        header("Location: success.php");
        exit;
    } else {
        echo "Failed to update course order: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
