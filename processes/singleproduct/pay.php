<?php

session_start();

if(isset($_SESSION["user"])){

    $order_id = $_POST["order_id"];
    $name = $_POST["name"];
    $price = (int)$_POST["price"];
    $email = $_POST["email"];
    $product_id = $_POST["product_id"];
    $qty = $_POST["qty"];

    require_once '../stripe/init.php';

    \Stripe\Stripe::setApiKey("sk_test_51LwqlKHh7AjlqoHpJVo84bmSYMaC6lSBEmvDs7yoaQTNtl8wAw84iw3Qu40FvbyjFT5auMAMtO7nhz30ULn5L9mv00myHNjlJ8");
    header('Content-Type: application/json');

    $YOUR_DOMAIN = 'http://localhost:80';

    $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [[
            'price_data' => [
                'currency' => 'lkr',
                'product_data' => [
                    'name' => $name,
                    'description'=>$order_id,
                ],
                'unit_amount' => (int)$price*100,
            ],
            'quantity' => $qty,
        ]],

        'mode' => 'payment',
        'metadata'=>[
            'email' => $email,
            "product_id"=> $product_id,
            'order_id'=>$order_id,
            "qty" => $qty,
        ],
        'success_url' => $YOUR_DOMAIN . '/Final_viva_project/processes/singleproduct/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.html/Final_viva_project/singleProductView.php',
    ]);

    $url = $checkout_session->url;

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);

}