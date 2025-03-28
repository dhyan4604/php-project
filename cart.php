<?php
session_start();
include 'nav.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];

        $cart_item = [
            'id' => $product_id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => 1
        ];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $cart_item;
        }

        // Set a success message for the session
        $_SESSION['success_message'] = "Item added to cart successfully!";

        // Redirect back to shop.php instead of cart.php
        header("Location: shop.php");
        exit();
    }

    if (isset($_POST['remove_item'])) {
        $remove_id = $_POST['remove_id'];
        unset($_SESSION['cart'][$remove_id]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        header("Location: cart.php");
        exit();
    }

    if (isset($_POST['clear_cart'])) {
        unset($_SESSION['cart']);
        header("Location: shop.php");
        exit();
    }

    if (isset($_POST['update_quantity'])) {
        $product_id = $_POST['product_id'];
        $action = $_POST['action'];

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                if ($action === "increase") {
                    $item['quantity'] += 1;
                } elseif ($action === "decrease" && $item['quantity'] > 1) {
                    $item['quantity'] -= 1;
                }
                break;
            }
        }

        header("Location: cart.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | VogueVista</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>



<div class="cart-container">
    <h2>Your Shopping Cart</h2>
    <table class="cart-table">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php
            $total_price = 0;
            foreach ($_SESSION['cart'] as $key => $item):
                $item_total = $item['price'] * $item['quantity'];
                $total_price += $item_total;
            ?>
            <tr>
                <td><img src="admin/uploads/<?= $item['image']; ?>" class="cart-img"></td>
                <td><?= $item['name']; ?></td>
                <td>₹<?= number_format($item['price'], 2); ?></td>
                <td>
                    <form action="cart.php" method="POST" class="quantity-form">
                        <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                        <button type="submit" name="update_quantity" value="decrease" class="qty-btn" onclick="this.form.action.value='decrease'">−</button>
                        <input type="text" class="quantity" value="<?= $item['quantity']; ?>" readonly>
                        <button type="submit" name="update_quantity" value="increase" class="qty-btn" onclick="this.form.action.value='increase'">+</button>
                        <input type="hidden" name="action" value="">
                    </form>
                </td>
                <td>₹<?= number_format($item_total, 2); ?></td>
                <td>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="remove_id" value="<?= $key; ?>">
                        <button type="submit" class="remove-btn" name="remove_item">Remove</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="total-section"><strong>Total Price:</strong></td>
                <td><strong>₹<?= number_format($total_price, 2); ?></strong></td>
                <td></td>
            </tr>
        <?php else: ?>
            <tr><td colspan="6">Your cart is empty.</td></tr>
        <?php endif; ?>
    </table>

    <div class="cart-buttons">
        <form action="cart.php" method="POST">
            <button type="submit" class="clear-btn" name="clear_cart">Clear Cart</button>
        </form>

        <?php if (!empty($_SESSION['cart'])): ?>
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<?php include 'footer.php'; ?>