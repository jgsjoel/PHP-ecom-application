<?php



require_once '../stripe/init.php';
require "../connection.php";
$stripe = new \Stripe\StripeClient('sk_test_51LwqlKHh7AjlqoHpJVo84bmSYMaC6lSBEmvDs7yoaQTNtl8wAw84iw3Qu40FvbyjFT5auMAMtO7nhz30ULn5L9mv00myHNjlJ8');

try {
  $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);

  if (isset($session)) {

    $metadata = $session->metadata;
    $email = $metadata->email;
    $order_id = $metadata->order_id;
    $product_id = $metadata->product_id;
    $qty = $metadata->qty;

    // Insert data into the database
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone('Asia/Colombo'));
    $dt->setTimestamp($timestamp);
    $dateTime = $dt->format('Y-m-d H:i:s');

    $product = Database::search("SELECT * FROM `product` WHERE id='" . $product_id . "'");

    $product_arr = $product->fetch_assoc();

    $user_address = Database::search("SELECT `district`.`name` AS `district` FROM `user_address` INNER JOIN `location` ON
    `location`.`id`=`user_address`.`location_id` INNER JOIN `district` ON `district`.`id`=
    `location`.`district_id` WHERE `user_address`.`user_email`='" . $email . "'");

    $user_details = $user_address->fetch_assoc();

    $shipping;
    if ($user_details["district"] == "Colombo") {
      $shipping = $product_arr["shipping_in_colombo"];
    } else {
      $shipping = $product_arr["shipping_outof_colombo"];
    }

    $newQty = (int)$product_arr["qty"] - $qty;

    Database::iud("UPDATE `product` SET `qty`='" . $newQty . "' WHERE `id`='" . $product_id . "'");

    // update purchase history table
    Database::iud("INSERT INTO `purchase_history`(`orderId`,`product_id`,`qty`,`datetime`,`user_email`) 
        VALUES('" . $order_id . "','$product_id','$qty','" . $dateTime . "','" . $email . "') ");

    http_response_code(200);

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Thank You</title>
      <link rel="icon" href="resources/images/Logo.png">
      <link rel="stylesheet" href="../../resources/css/bootstrap.css">
    </head>

    <body style="background-color: rgb(233, 232, 232);">

      <div class="container">
        <div class="row vh-100 justify-content-center align-content-center">
          <div class="col-12 text-center">
            <h1 class="text-black-50">Thank you for your payment</h1>
            <a class="btn btn-danger" href="../../singleProductView.php">Go Back</a>
            <a class="btn btn-primary" href="../../invoice.php?oid=<?php echo $order_id ?>">Check Invoice</a>
          </div>

        </div>
      </div>

    </body>

    </html>

<?php
// 
  }
} catch (Error $e) {
  http_response_code(500);
  // echo json_encode(['error' => $e->getMessage()]);
}

?>