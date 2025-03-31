<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $payment = $_POST['payment'];
    $total_amount = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['price'];
    }

    $order_sql = "INSERT INTO orders (fullname, email, phone, address, city, state, zip, payment, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($order_sql);
    $stmt->bind_param("ssssssssd", $fullname, $email, $phone, $address, $city, $state, $zip, $payment, $total_amount);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['id'];
            $price = $item['price'];
            $order_items_sql = "INSERT INTO order_items (order_id, product_id, price) VALUES (?, ?, ?)";
            $order_stmt = $conn->prepare($order_items_sql);
            $order_stmt->bind_param("iid", $order_id, $product_id, $price);
            $order_stmt->execute();
        }

        unset($_SESSION['cart']);
        $_SESSION['success_message'] = "Order placed successfully!";
        header("Location: shop.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
