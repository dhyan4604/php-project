<?php
session_start();
include '../db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $featured = isset($_POST['featured']) ? 1 : 0; // Check if featured is selected

    // Convert price to INR format
    $formatted_price = number_format((float)$price, 2, '.', '');

    // Insert product details first (including featured flag)
    $sql = "INSERT INTO products (name, description, price, stock, featured) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $name, $description, $formatted_price, $stock, $featured);
    
    if ($stmt->execute()) {
        $product_id = $stmt->insert_id; // Get last inserted product ID
        
        // Handle multiple file uploads
        if (!empty($_FILES['images']['name'][0])) {
            $target_dir = "uploads/";
            foreach ($_FILES['images']['name'] as $key => $image_name) {
                $image_tmp = $_FILES['images']['tmp_name'][$key];
                $image_path = $target_dir . basename($image_name);
                
                if (move_uploaded_file($image_tmp, $image_path)) {
                    // Insert image path into the product_images table
                    $sql_image = "INSERT INTO product_images (product_id, image_path) VALUES (?, ?)";
                    $stmt_image = $conn->prepare($sql_image);
                    $stmt_image->bind_param("is", $product_id, $image_path);
                    $stmt_image->execute();
                }
            }
        }

        echo "<p>Product added successfully! <a href='manage_products.php'>View Products</a></p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="add_product.css">
</head>
<body>

<div class="container">
    <h2>Add Product</h2>
    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" required placeholder="Product Name">
        <textarea name="description" required placeholder="Product Description"></textarea>
        <input type="number" step="0.01" name="price" required placeholder="Price (₹)">
        <input type="number" name="stock" required placeholder="Stock Quantity">
        <input type="file" name="images[]" multiple required>

        <!-- Featured Checkbox -->
        <label>
            <input type="checkbox" name="featured"> Mark as Featured Product
        </label>

        <button type="submit">Add Product</button>
    </form>
    <a href="manage_products.php">Back to Manage Products</a>
</div>

</body>
</html>
