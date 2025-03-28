<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit();
}

$product_id = $_GET['id'];

// Fetch product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: shop.php");
    exit();
}

$product = $result->fetch_assoc();

// Fetch product images
$image_sql = "SELECT image_path FROM product_images WHERE product_id = ?";
$image_stmt = $conn->prepare($image_sql);
$image_stmt->bind_param("i", $product_id);
$image_stmt->execute();
$image_result = $image_stmt->get_result();

$images = [];
while ($row = $image_result->fetch_assoc()) {
    $images[] = $row['image_path'];
}

$main_image = $images[0] ?? 'default.jpg'; // Set first image as default, fallback to 'default.jpg'
?>
<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> | VogueVista</title>
    <link rel="stylesheet" href="product_details.css">
    <script>
        function changeMainImage(newSrc) {
            document.getElementById('main-product-image').src = newSrc;
        }
    </script>
</head>
<body>



<section class="product-details">
    <!-- Left: Image Gallery -->
    <div class="product-image">
        <img id="main-product-image" src="admin/<?= $main_image ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        
        <!-- Thumbnails -->
        <div class="image-thumbnails">
            <?php foreach ($images as $img): ?>
                <img src="admin/<?= $img ?>" alt="Thumbnail" onclick="changeMainImage('admin/<?= $img ?>')">
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Right: Product Info -->
    <div class="product-info">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <p class="price">₹<?= number_format($product['price'], 2) ?></p>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
            <input type="hidden" name="price" value="<?= $product['price'] ?>">
            <input type="hidden" name="image" value="<?= $main_image ?>">
            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
    </div>
</section>

</body>
</html>

<?php $conn->close(); ?>
<?php include 'footer.php'; ?>