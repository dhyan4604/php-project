<?php
session_start();
include 'db.php';
include 'nav.php';

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty!'); window.location.href='shop.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | VogueVista</title>
    <link rel="stylesheet" href="checkout.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>

<section class="checkout-container">
    <h2>Checkout</h2>
    
    <form action="process_checkout.php" method="POST">
        <div class="section">
            <h3>Billing Details</h3>
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Shipping Address" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="state" placeholder="State" required>
            <input type="text" name="zip" placeholder="ZIP Code" required>
        </div>

        <div class="section">
            <h3>Payment Method</h3>
            <label><input type="radio" name="payment" value="cod" required> Cash on Delivery</label>
            <label><input type="radio" name="payment" value="card" required> Credit/Debit Card</label>
        </div>

        <div class="cart-summary">
            <h3>Order Summary</h3>
            <ul>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item) {
                    echo "<li>{$item['name']} - ₹" . number_format($item['price'], 2) . "</li>";
                    $total += $item['price'];
                }
                ?>
            </ul>
            <p><strong>Total: ₹<?php echo number_format($total, 2); ?></strong></p>
        </div>

        <button type="submit" class="checkout-btn">Place Order</button>
    </form>
</section>

</body>
</html>

<?php include 'footer.php'; ?>
