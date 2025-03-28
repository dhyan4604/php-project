<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch products
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<header>
    <div class="logo">VogueVista - Admin Panel</div>
    <nav>
        <a href="admin_home.php">Dashboard</a>
        <a href="manage_products.php">Products</a>
        <a href="manage_orders.php">Orders</a>
        <a href="manage_users.php">Users</a>
        <a href="../logout.php">Logout</a>
    </nav>
</header>

<section class="container">
    <h2>Manage Products</h2>
    <a href="add_product.php" class="btn-add">Add New Product</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Fetch the first image for this product
                    $product_id = $row['id'];
                    $image_sql = "SELECT image_path FROM product_images WHERE product_id = ? LIMIT 1";
                    $image_stmt = $conn->prepare($image_sql);
                    $image_stmt->bind_param("i", $product_id);
                    $image_stmt->execute();
                    $image_result = $image_stmt->get_result();
                    $image_row = $image_result->fetch_assoc();
                    $product_image = $image_row ? $image_row['image_path'] : 'default.jpg'; // Default image if no image found
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><img src="<?= $product_image ?>" alt="Product Image" class="product-img"></td>
                        <td><?= $row['name'] ?></td>
                        <td>₹<?= number_format($row['price'], 2) ?></td>
                        <td><?= $row['stock'] ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                            <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No products found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

</body>
</html>
