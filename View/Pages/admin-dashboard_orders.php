<?php
require_once __DIR__ . "/../../Controller/admin_orders_data.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites - Admin Orders</title>
<link rel="stylesheet" href="../Design/Design_student_login.css">
</head>
<body class="dashboard-body">

<div class="dashboard-wrapper">

    <div class="sidebar">
        <h2 class="sidebar-title">AIUBites</h2>
        <p class="sidebar-subtitle">Admin Panel</p>

        <nav>
            
            <a href="admin-dashboard_users.php" class="nav-link">Manage Users</a>
            <a href="admin-dashboard_canteens.php" class="nav-link">Canteens</a>
            <a href="admin-dashboard_orders.php" class="nav-link active">Orders</a>
        </nav>

        <a href="admin-login.php" class="logout-link">Logout</a>
    </div>

    <div class="main-content">
        <h1>Orders</h1>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $orders->fetch_assoc()) { ?>
                <tr>
                    <td>#AIB-<?php echo $row['order_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['items']); ?></td>
                    <td>৳ <?php echo number_format($row['total_amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($row['status'])); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>