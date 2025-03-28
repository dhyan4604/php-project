<?php
session_start();
include '../db.php'; // Adjust path if needed

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect if not an admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | VogueVista</title>
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

<section class="dashboard">
    <h1>Welcome, Admin!</h1>
    <div class="dashboard-grid">
        <div class="card">
            <h3>Total Users</h3>
            <p>150</p> <!-- Replace with DB count -->
        </div>
        <div class="card">
            <h3>Total Orders</h3>
            <p>320</p> <!-- Replace with DB count -->
        </div>
        <div class="card">
            <h3>Products Listed</h3>
            <p>85</p> <!-- Replace with DB count -->
        </div>
        <div class="card">
            <h3>Revenue</h3>
            <p>$12,340</p> <!-- Replace with DB calculation -->
        </div>
    </div>
</section>

</body>
</html>
