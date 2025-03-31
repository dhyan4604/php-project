<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VogueVista</title>
</head>
<body>
<header>
    <div class="logo">VogueVista</div>
    <nav>
        <a href="index.php">Home</a>
        <a href="shop.php">Shop</a>
        <a href="order.php">Orders</a>
        <a href="cart.php">Cart</a>
        <a href="about.php">About</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout (<?= $_SESSION['name']; ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
</body>
</html>