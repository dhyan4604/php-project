<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'], $_POST['order_status'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $update_query = "UPDATE orders SET order_status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $order_status, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Order status updated successfully!'); window.location.href='manage_orders.php';</script>";
    } else {
        echo "<script>alert('Failed to update order status!'); window.location.href='manage_orders.php';</script>";
    }
} else {
    header("Location: manage_orders.php");
    exit();
}
?>
