    <?php
    session_start();
    include 'db.php';
    include 'nav.php';

    // Check if user is logged in
    if (!isset($_SESSION['email'])) {
        echo "<script>alert('Please log in to view your orders.'); window.location.href='login.php';</script>";
        exit();
    }

    $user_email = $_SESSION['email'];

    // Fetch all orders for the logged-in user
    $order_query = "SELECT * FROM orders WHERE email = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($order_query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Orders | VogueVista</title>
        <link rel="stylesheet" href="order.css">
        <link rel="stylesheet" href="index.css">
    </head>
    <body>

    <div class="orders-container">
        <h2>My Orders</h2>

        <?php if (!empty($orders)): ?>
            <table class="orders-table">
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Details</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id']; ?></td>
                        <td>₹<?= number_format($order['total_amount'], 2); ?></td>
                        <td><?= ucfirst($order['payment']); ?></td>
                        <td><?= ucfirst($order['order_status']); ?></td>
                        <td><?= date("d-m-Y H:i:s", strtotime($order['created_at'])); ?></td>
                        <td>
                            <button class="view-details-btn" onclick="toggleDetails(<?= $order['id']; ?>)">View</button>
                        </td>
                    </tr>
                    <tr class="order-details" id="details-<?= $order['id']; ?>" style="display: none;">
                        <td colspan="6">
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
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>

    <script>
        function toggleDetails(orderId) {
            let detailsRow = document.getElementById('details-' + orderId);
            if (detailsRow.style.display === 'none') {
                detailsRow.style.display = 'table-row';
            } else {
                detailsRow.style.display = 'none';
            }
        }
    </script>

    </body>
    </html>

    <?php include 'footer.php'; ?>
