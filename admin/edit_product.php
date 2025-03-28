<?php
session_start();
include '../db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get product details if ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if (!$product) {
        echo "<p>Product not found.</p>";
        exit();
    }
}

// Update product details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $imagePath = $product['image']; // Keep the old image path

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "uploads/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $newImagePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $newImagePath)) {
           
            if (!empty($product['image']) && file_exists($product['image'])) {
                unlink($product['image']);
            }
            $imagePath = $newImagePath; 
        } else {
            echo "<p>Error uploading new image.</p>";
            exit();
        }
    }

    // Update database
    $sql = "UPDATE products SET name=?, description=?, price=?, stock=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssi", $name, $description, $price, $stock, $imagePath, $product_id);

    if ($stmt->execute()) {
        echo "<p>Product updated successfully! <a href='manage_products.php'>Back to Products</a></p>";
    } else {
        echo "<p>Error updating product: " . $stmt->error . "</p>";
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="add_product.css">
</head>
<body>

<div class="container">
    <h2>Edit Product</h2>
    <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" required placeholder="Product Name" value="<?php echo $product['name']; ?>">
        <textarea name="description" required placeholder="Product Description"><?php echo $product['description']; ?></textarea>
        <input type="number" step="0.01" name="price" required placeholder="Price" value="<?php echo $product['price']; ?>">
        <input type="number" name="stock" required placeholder="Stock Quantity" value="<?php echo $product['stock']; ?>">

        <label>Current Image:</label><br>
        <img src="<?php echo $product['image']; ?>" alt="Product Image" width="100"><br>

        <label>Upload New Image (optional):</label>
        <input type="file" name="image">

        <button type="submit">Update Product</button>
    </form>
    <a href="manage_products.php">Back to Manage Products</a>
</div>

</body>
</html>
