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

    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone('Asia/Colombo'));
    $dt->setTimestamp($timestamp);
    $dateTime = $dt->format('Y-m-d H:i:s');

    $cart = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "'");

    for ($x = 0; $x < $cart->num_rows; $x++) {

      $cart_arr = $cart->fetch_assoc();
      $product = Database::search("SELECT * FROM `product` WHERE id='" . $cart_arr["product_id"] . "'");
      $product_arr = $product->fetch_assoc();

      $qty = (int)$cart_arr["qty"];
      $newQty = (int)$product_arr["qty"] - $qty;

      if ($newQty >= 0) {

        // update purchase history table
        Database::iud("INSERT INTO `purchase_history`(`orderId`,`product_id`,`qty`,`datetime`,`user_email`) 
      VALUES('" . $order_id . "','" . $cart_arr["product_id"] . "','$qty','" . $dateTime . "','" . $email . "') ");

        //delete product from cart when euuals 0
        $status = 1;
        if ($newQty == 0) {
          $status = 2;
          Database::iud("DELETE FROM `cart` WHERE `user_email`='" . $email . "' AND `product_id`='" . $cart_arr["product_id"] . "'");
        }
        Database::iud("UPDATE `product` SET `qty`='" . $newQty . "',`status_id`='" . $status . "' WHERE `id`='" . $cart_arr["product_id"] . "'");
      }
    }

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
          <h1>Thank you for your payment</h1>
          <a class="btn btn-danger" href="../../cart.php">Go Back</a>
          <a class="btn btn-primary" href="../../invoice.php?oid=<?php echo $order_id ?>" >Check Invoice.</a>
          </div>
          
        </div>
      </div>

    </body>

    </html>

<?php

  } else {
    header("Location: ");
  }
} catch (Error $e) {
  http_response_code(500);
  // echo json_encode(['error' => $e->getMessage()]);
}

?>