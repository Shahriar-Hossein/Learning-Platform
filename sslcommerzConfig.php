<?php
// SSLCommerz Configuration

// Sandbox API credentials (replace these with your actual credentials for production)
$store_id = "zante65e3a05559d46";
$store_passwd = "zante65e3a05559d46@ssl";

// API URLs for sandbox and production
$sandbox_url = "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
$production_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";

// Set the API URL based on whether you're in sandbox or production mode
$is_sandbox = true; // Set to false for production
$api_url = $is_sandbox ? $sandbox_url : $production_url;
?>
