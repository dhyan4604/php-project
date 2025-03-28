<?php
session_start();
include 'db.php';
include 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | VogueVista</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<section class="hero">
    <div class="hero-content">
        <h1>Welcome to VogueVista, <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'Fashion Enthusiast' ?>!</h1>
        <p>Discover the latest trends in fashion and style your wardrobe with elegance.</p>
        <a href="shop.php" class="btn">Shop Now</a>
    </div>
</section>

<section class="categories">
    <h2>Shop by Category</h2>
    <div class="category-grid">
        <div class="category">
            <img src="https://cdn-om.cdnpk.net/users/868/86804582/uploads/e4640d00-f673-4b72-9c56-3daeaa1296e4/e4640d00-f673-4b72-9c56-3daeaa1296e4-thumb.jpg?token=exp=1743227481~hmac=1ff1ae6b9e80dab5c9c0ca3a3191df9b" alt="Men's Fashion">
            <h3>Top Wear</h3>
        </div>
        <div class="category">
            <img src="https://img.freepik.com/free-photo/blue-jeans-fabric-details_150588-32.jpg?t=st=1743141600~exp=1743145200~hmac=9de65dc7c06543e17027c0f32fd96479e58956c94f9ae1b0c85d7cd3a4d6b76b&w=740" alt="Women's Fashion">
            <h3>Bottom Wear</h3>
        </div>
    </div>
</section>

<section class="featured-products">
    <h2>Featured Collection</h2>
    <div class="product-grid">
        <?php
        // Fetch featured products
        $sql = "SELECT p.id, p.name, p.price 
                FROM products p 
                WHERE p.featured = 1 
                ORDER BY p.id DESC 
                LIMIT 6";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_id = $row['id'];

                // Fetch the first product image
                $image_sql = "SELECT image_path FROM product_images WHERE product_id = ? LIMIT 1";
                $image_stmt = $conn->prepare($image_sql);
                $image_stmt->bind_param("i", $product_id);
                $image_stmt->execute();
                $image_result = $image_stmt->get_result();
                $image_row = $image_result->fetch_assoc();
                $product_image = $image_row ? 'admin/' . $image_row['image_path'] : 'admin/default.jpg'; 

                echo '<div class="product">';
                echo '<a href="product_details.php?id=' . $row['id'] . '">';
                echo '<img src="' . $product_image . '" alt="' . htmlspecialchars($row['name'], ENT_QUOTES) . '">';
                echo '<h3>' . htmlspecialchars($row['name'], ENT_QUOTES) . '</h3>';
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
            echo "<p>No featured products available.</p>";
        }
        ?>
    </div>
</section>


<section class="testimonials">
    <h2>What Our Customers Say</h2>
    <div class="testimonial-grid">
        <div class="testimonial">
            <p>"Absolutely love the quality and designs. VogueVista never disappoints!"</p>
            <h4>- Sarah L.</h4>
        </div>
        <div class="testimonial">
            <p>"Best online shopping experience! Super fast delivery and great customer service."</p>
            <h4>- Michael B.</h4>
        </div>
        <div class="testimonial">
            <p>"The fabric quality is outstanding. Worth every penny!"</p>
            <h4>- Emily R.</h4>
        </div>
    </div>
</section>

<section class="newsletter">
    <h2>Stay Updated</h2>
    <p>Subscribe to get the latest fashion trends and exclusive offers.</p>
    <form action="subscribe.php" method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Subscribe</button>
    </form>
</section>

</body>
</html>
<?php include 'footer.php'; ?>
