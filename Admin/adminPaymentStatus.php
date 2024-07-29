<?php
include('../dbConnection.php');

const TITLE = 'Payment Status';
const PAGE = 'paymentstatus';

include('./adminInclude/sidebar.php');

// Include SSLCommerz configuration and helper files
require_once("../sslcommerzConfig.php");
require_once("../sslcommerzHelper.php");

$order_id = "";
$responseParamList = array();

if (isset($_POST["ORDER_ID"]) && $_POST["ORDER_ID"] != "") {
    // Retrieve order ID from POST request
    $ORDER_ID = $_POST["ORDER_ID"];

    // Create an array with required parameters for status query
    $requestParamList = array(
        'store_id' => $store_id,
        'store_passwd' => $store_passwd,
        'order_id' => $ORDER_ID,
    );

    // Get payment status from SSLCommerz
    $responseParamList = getSslCommerzTransactionStatus($requestParamList);
}
?>  

<div class="container">
    <h2 class="text-center my-4">Payment Status</h2>
    <form method="post" action="">
        <div class="form-group row">
            <label class="offset-sm-3 col-form-label">Order ID: </label>
            <div>
                <input class="form-control mx-3" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo $ORDER_ID ?>">
            </div>
            <div>
                <input class="btn btn-primary mx-4" value="View" type="submit">
            </div>
        </div>
    </form>
</div>

<div class="container">
    <?php
    // Display payment status if available
    if (isset($responseParamList) && !empty($responseParamList)) {
        ?>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h2 class="text-center">Payment Receipt</h2>
                <table class="table table-bordered">
                    <tbody>
                        <?php
                        foreach ($responseParamList as $paramName => $paramValue) {
                            ?>
                            <tr>
                                <td><label><?php echo $paramName ?></label></td>
                                <td><?php echo $paramValue ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td><button class="btn btn-primary" onclick="javascript:window.print();">Print Receipt</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    } else {
        // Display a message if payment status is not available
        echo "<p class='text-center'>Payment status not available for the provided Order ID.</p>";
    }
    ?>
</div>

</div> <!-- div Row close from header -->
</div> <!-- div Conatiner-fluid close from header -->

<?php
include('./adminInclude/footer.php');
?>
