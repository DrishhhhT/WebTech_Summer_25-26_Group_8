<?php
require_once __DIR__ . "/../../Controller/order_history_validation.php";

$isStaff = ($role === 'staff');
$homeLink = $isStaff ? "staff_dashboard_home.php" : "student_dashboard_home.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites — Order History</title>
<link rel="stylesheet" href="../Design/student_OrderHistory.css">
</head>
<body>

<div id="oh-wrap">

  <div class="oh-topbar">
    <div class="oh-brand">
      <div>
        <div class="oh-name">AIUBites</div>
        <div class="oh-tag">  Order History</div>
      </div>
    </div>
  </div>

  <div class="oh-actions">
    <a href="<?php echo $homeLink; ?>" id="ohHomeBtn" class="oh-home-btn"> Home </a>
  </div>

  <div class="oh-card">
    <div class="oh-card-head">
      <div class="oh-card-title">Your All Orders</div>
      <span class="oh-count"><?php echo $orderCount; ?> orders found</span>
    </div>

    <div class="oh-list-head">
      <span class="oh-col-order">Order</span>
      <?php if ($isStaff) { ?>
      <span class="oh-col-customer">Customer</span>
      <?php } ?>
      <span class="oh-col-items">Items</span>
      <span class="oh-col-date">Date</span>
      <span class="oh-col-total">Total</span>
      <span class="oh-col-status">Status</span>
      <span class="oh-col-action"></span>
    </div>

    <div class="oh-list">

        <?php if ($orderCount > 0) { ?>
            <?php while ($order = $orders->fetch_assoc()) { ?>
                <?php
                    $status = $order['status'];
                    $statusClass = ($status === 'completed') ? 'oh-status-done'
                                 : (($status === 'cancelled') ? 'oh-status-cancel' : 'oh-status-pending');
                ?>
                <div class="oh-row">
                    <div class="oh-col-order">
                        <div class="oh-food-cell">
                            <span class="oh-oid">#AIB-<?php echo $order['order_id']; ?></span>
                        </div>
                    </div>
                    <?php if ($isStaff) { ?>
                    <div class="oh-col-customer" data-label="Customer"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                    <?php } ?>
                    <div class="oh-col-items" data-label="Items"><?php echo htmlspecialchars($order['items']); ?></div>
                    <div class="oh-col-date" data-label="Date"><?php echo date("M j, g:i A", strtotime($order['created_at'])); ?></div>
                    <div class="oh-col-total oh-total" data-label="Total">৳ <?php echo $order['total_amount']; ?></div>

                    <div class="oh-col-status" data-label="Status">
                        <?php if ($isStaff) { ?>
                            <form method="POST" action="student_dashboard_OrderHistory.php" class="status-form">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <select name="status" class="status-select oh-status-<?php echo $status; ?>" onchange="this.form.submit()">
                                    <?php foreach ($statusLabels as $value => $label) { ?>
                                        <option value="<?php echo $value; ?>" <?php echo $status === $value ? 'selected' : ''; ?>>
                                            <?php echo $label; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </form>
                        <?php } else { ?>
                            <span class="oh-status <?php echo $statusClass; ?>">
                                <?php echo $statusLabels[$status] ?? ucfirst($status); ?>
                            </span>
                        <?php } ?>
                    </div>

                </div>
            <?php } ?>
        <?php } else { ?>
            <p style="padding: 20px;"><?php echo $isStaff ? "No orders yet." : "You haven't placed any orders yet."; ?></p>
        <?php } ?>

    </div>
  </div>

</div>

<script>

    let ohHomeBtn = document.getElementById("ohHomeBtn");

    ohHomeBtn.addEventListener("click", function (e) {
        e.preventDefault();
        window.location.href = "<?php echo $homeLink; ?>";
    });

</script>

</body>
</html>