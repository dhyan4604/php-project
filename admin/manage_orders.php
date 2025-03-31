<?php
session_start();
include '../db.php';


// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch all orders from the database
$order_query = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders | Admin Panel</title>
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
    <h2>Manage Orders</h2>

    <table class="orders-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?= $order['id']; ?></td>
                    <td><?= htmlspecialchars($order['fullname']); ?></td>
                    <td>₹<?= number_format($order['total_amount'], 2); ?></td>
                    <td><?= ucfirst($order['payment']); ?></td>
                    <td>
                        <form method="post" action="update_order_status.php">
                            <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                            <select name="order_status" onchange="this.form.submit()">
                                <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?= $order['order_status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="Shipped" <?= $order['order_status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?= $order['order_status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Canceled" <?= $order['order_status'] == 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                            </select>
                        </form>
                    </td>
                    <td><?= date("d-m-Y H:i:s", strtotime($order['created_at'])); ?></td>
                    <td>
                        <button class="view-details-btn" onclick="toggleDetails(<?= $order['id']; ?>)">View</button>
                    </td>
                </tr>
                <tr class="order-details" id="details-<?= $order['id']; ?>" style="display: none;">
                    <td colspan="7">
                        <div class="order-card">
                            <h3>Order #<?= $order['id']; ?></h3>
                            <p><strong>Name:</strong> <?= $order['fullname']; ?></p>
                            <p><strong>Address:</strong> <?= $order['address']; ?>, <?= $order['city']; ?>, <?= $order['state']; ?> - <?= $order['zip']; ?></p>
                            <p><strong>Payment:</strong> <?= ucfirst($order['payment']); ?></p>
                            <p><strong>Total:</strong> ₹<?= number_format($order['total_amount'], 2); ?></p>

                            <h4>Items:</h4>
                            <div class="order-items">
                                <?php
                                $order_id = $order['id'];
                                $items_query = "SELECT p.name, p.image, oi.price 
                                                FROM order_items oi 
                                                JOIN products p ON oi.product_id = p.id 
                                                WHERE oi.order_id = ?";
                                $item_stmt = $conn->prepare($items_query);
                                $item_stmt->bind_param("i", $order_id);
                                $item_stmt->execute();
                                $items_result = $item_stmt->get_result();
                                while ($item = $items_result->fetch_assoc()):
                                ?>
                                    <div class="order-item">
                                        <img src="admin/<?= htmlspecialchars($item['image']); ?>" 
                                        alt="<?= htmlspecialchars($item['name']); ?>" 
                                        onerror="this.onerror=null; this.src='admin/uploads/default.jpg';">
                                        <p><?= htmlspecialchars($item['name']); ?> - ₹<?= number_format($item['price'], 2); ?></p>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<script>
    function toggleDetails(orderId) {
        let detailsRow = document.getElementById('details-' + orderId);
        detailsRow.style.display = (detailsRow.style.display === 'none') ? 'table-row' : 'none';
    }
</script>

</body>
</html>
