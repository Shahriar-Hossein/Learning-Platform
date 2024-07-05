<?php
    include("config.php");
    require __DIR__ . "/vendor/autoload.php";

   
   
    $ORDER_ID          = $_POST["order_id"];
    $CUST_ID           = $_POST["CUST_ID"];
    $TXN_AMOUNT        = $_POST["TXN_AMOUNT"];


    
$stripe_secret_key = "sk_test_51PGPEYF5zjty4XeiUnvXcTfqoLkevC0dZL0hFirW554FYO9yYtbysUzs0GBW06a3UlD88Medy7nKWz31P7YRyNYZ00pgvyuRiV";

\Stripe\Stripe::setApiKey($stripe_secret_key);

   
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "success_url" => "http://localhost/elearning/success.php",
        "cancel_url" => "http://localhost/elearning/index.php",
    ]);

    if($charge){
      header("Location:success.php?");
    }
?>