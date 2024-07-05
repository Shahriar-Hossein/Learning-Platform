<?php 
// Product Details 
// Minimum amount is $0.50 US 
// Test Stripe API configuration 

define('STRIPE_API_KEY', 'sk_test_51PGPEYF5zjty4XeiUnvXcTfqoLkevC0dZL0hFirW554FYO9yYtbysUzs0GBW06a3UlD88Medy7nKWz31P7YRyNYZ00pgvyuRiV');  
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51PGPEYF5zjty4XeiJ8nde3VmmaldmB2F2gpwvw3xGEp7FTpIF0buhjTw7NQlaCGInlolsJxfPRX6PTRGH4VHRrSP00mt4FInyU'); 

define('STRIPE_SUCCESS_URL', 'http://localhost/stripe/success.php'); 
define('STRIPE_CANCEL_URL', 'http://localhost/stripe/cancel.php'); 

// Database configuration   
define('DB_HOST', 'localhost');  
define('DB_USERNAME', 'root');  
define('DB_PASSWORD', '');  
define('DB_NAME', 'lms_db'); 
?>