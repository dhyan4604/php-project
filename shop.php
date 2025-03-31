<?php
session_start();
include 'db.php';
include 'nav.php';


$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | VogueVista</title>
    <link rel="stylesheet" href="shop.css">
</head>
<body>


<?php if (isset($_SESSION['success_message'])): ?>
    <div class="cart-notification"><?= $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']);  ?>
<?php endif; ?>

<section class="shop-header">
    <h1>Explore the Latest Fashion Trends</h1>
    <p>Discover the perfect outfit that matches your style.</p>
</section>

<section class="product-grid">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['id'];
            $image_sql = "SELECT image_path FROM product_images WHERE product_id = ? LIMIT 1";
            $image_stmt = $conn->prepare($image_sql);
            $image_stmt->bind_param("i", $product_id);
            $image_stmt->execute();
            $image_result = $image_stmt->get_result();
            $image_row = $image_result->fetch_assoc();
            $product_image = $image_row ? $image_row['image_path'] : 'default.jpg'; 
            
            echo '<div class="product">';
            echo '<a href="product_details.php?id=' . $row['id'] . '">';
            echo '<img src="admin/' . $product_image . '" alt="' . $row['name'] . '">';
            echo '<h3>' . $row['name'] . '</h3>';
            echo '<p>₹' . number_format($row['price'], 2) . '</p>';
            echo '</a>';
            echo '<form action="cart.php" method="POST">';
            echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
            echo '<input type="hidden" name="name" value="' . $row['name'] . '">';
            echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
            echo '<input type="hidden" name="image" value="' . $product_image . '">';
            echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p>No products available.</p>";
    }
    ?>
</section>


<style>
.cart-notification {
    position: absolute;
    top: 80px;
    right: 20px;
    background: #4CAF50;
    color: white;
    padding: 12px 18px;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    font-size: 14px;
    z-index: 1000;
    animation: fadeOut 3s ease-in-out forwards;
}

@keyframes fadeOut {
    0% { opacity: 1; }
    80% { opacity: 1; }
    100% { opacity: 0; display: none; }
}
</style>

</body>
</html>

<?php $conn->close(); ?>
<?php include 'footer.php'; ?>