<?php
require_once __DIR__ . "/../../Controller/order_history_validation.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AIUBites — Order List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Design/staff_orderList.css">
</head>

<body>

    <div class="page-wrapper">

        <div id="screen-wrap">

            <div class="ol-hero">
                <h1>Order List</h1>
                <p>All customer orders placed today.</p>
            </div>

            <div class="ol-actions">
                <a href="staff_dashboard_home.php" id="olHomeBtn" class="ol-home-btn">Home</a>
            </div>

            <div class="ol-card">

                <div class="ol-card-head">
                    <div class="ol-card-title">Customer Orders</div>
                    <span class="ol-count" id="olCount"><?php echo $orderCount; ?> orders</span>
                </div>

                <div class="ol-list-head">
                    <span class="ol-col-order">Order</span>
                    <span class="ol-col-customer">Customer</span>
                    <span class="ol-col-items">Items</span>
                    <span class="ol-col-total">Total</span>
                    <span class="ol-col-status">Status</span>
                </div>

                <div class="ol-list" id="olList">

                    <?php if ($orderCount > 0) { ?>
                        <?php while ($order = $orders->fetch_assoc()) { ?>
                            <div class="ol-row" data-status="<?php echo $order['status']; ?>">
                                <div class="ol-col-order">
                                    <span class="ol-oid">#AIB-<?php echo $order['order_id']; ?></span>
                                </div>
                                <div class="ol-col-customer" data-label="Customer"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                                <div class="ol-col-items" data-label="Items"><?php echo htmlspecialchars($order['items']); ?></div>
                                <div class="ol-col-total ol-total" data-label="Total">৳ <?php echo $order['total_amount']; ?></div>
                                <div class="ol-col-status" data-label="Status">
                                    <form method="POST" action="staff_dashboard_orderList.php" class="status-form">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <select name="status" class="status-select ol-status-<?php echo $order['status']; ?>" onchange="this.form.submit()">
                                            <?php foreach ($statusLabels as $value => $label) { ?>
                                                <option value="<?php echo $value; ?>" <?php echo $order['status'] === $value ? 'selected' : ''; ?>>
                                                    <?php echo $label; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p style="padding: 20px;">No orders yet.</p>
                    <?php } ?>

                </div>

            </div>

        </div>

    </div>

    <script>
        let olHomeBtn = document.getElementById("olHomeBtn");
        olHomeBtn.addEventListener("click", function (e) {
            e.preventDefault();
            window.location.href = "staff_dashboard_home.php";
        });
    </script>

</body>

</html>