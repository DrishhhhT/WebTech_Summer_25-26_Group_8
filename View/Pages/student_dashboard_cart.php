<?php
require_once __DIR__ . "/../../Controller/view_cart_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites — Cart</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../Design/student_cart.css">
</head>
<body>

<div id="screen-wrap">

  <div class="topbar">
    <div class="brand">
      <div class="mark"></div>
      <div>
        <div class="name">AIUBites</div>
        <div class="tag">Student Launge.Open until 6:00 PM</div>
      </div>
    </div>
  </div>

  <div class="cart-actions">
    <a href="student_dashboard_home.php" id="backToMenuBtn" class="back-link">Home</a>
  </div>

  <div class="cart-head">
    <h1>Your Cart</h1>
    <p><span id="cartItemCount"><?php echo $itemCount; ?></span> items, Student Launge.</p>
  </div>

  <div class="cart-layout">

    <div class="card">
      <div class="card-title">Items</div>

      <div id="cartItemsList">

        <?php if ($itemCount > 0) { ?>
            <?php foreach ($cartItems as $item) { ?>
                <div class="cart-item" data-id="<?php echo $item['id']; ?>">
                    <div class="thumb"></div>
                    <div class="info">
                        <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                    </div>
                    <div class="qty-box">
                        <span class="qty-label">Qty</span>
                        <span class="qty-fixed-value"><?php echo $item['qty']; ?></span>
                    </div>
                    <div class="item-price">৳ <?php echo $item['lineTotal']; ?></div>
                    <a href="../../Controller/remove-cart-item.php?id=<?php echo $item['id']; ?>">Remove</a>
                </div>
            <?php } ?>
        <?php } ?>

      </div>

      <p id="cartEmptyMsg" style="display:<?php echo $itemCount > 0 ? 'none' : 'block'; ?>;">Your cart is empty.</p>

    </div>

    <div class="card">
      <div class="card-title">Checkout</div>

      <div class="summary-row">
        <span>Subtotal</span>
        <span id="cartSubtotalValue">৳ <?php echo $subtotal; ?></span>
      </div>
      <div class="summary-row">
        <span>Service fee</span>
        <span id="cartServiceFeeValue">৳ <?php echo $fee; ?></span>
      </div>
      <div class="summary-row total">
        <span>Total</span>
        <span class="total-value" id="cartTotalValue">৳ <?php echo $total; ?></span>
      </div>

      <div class="section-label">Payment Method</div>

      <label class="pay-option selected">
        <input type="checkbox" name="payment" checked>
        <div class="pay-info">
          <div class="pay-name">Pay at Counter</div>
          <div class="pay-desc">Cash on pickup</div>
        </div>
      </label>

      <a href="javascript:void(0);" id="placeOrderBtn" class="checkout-btn <?php echo $itemCount == 0 ? 'checkout-btn-empty' : ''; ?>">
        Place Order<span id="checkoutTotalValue"><?php echo $total; ?></span>
      </a>
    </div>

  </div>

</div>

<script>

    let backToMenuBtn = document.getElementById("backToMenuBtn");
    backToMenuBtn.addEventListener("click", function (e) {
        e.preventDefault();
        window.location.href = "student_dashboard_home.php";
    });

    let payOptions = document.getElementsByClassName("pay-option");

    for (let p = 0; p < payOptions.length; p++) {
        let payCheckbox = payOptions[p].getElementsByTagName("input")[0];

        payCheckbox.addEventListener("change", function () {
            if (this.checked) {
                this.parentElement.className = "pay-option selected";
            } else {
                this.parentElement.className = "pay-option";
            }
        });
    }

    let placeOrderBtn = document.getElementById("placeOrderBtn");
    let itemCount = <?php echo $itemCount; ?>;
    let currentTotal = <?php echo $total; ?>;

    placeOrderBtn.addEventListener("click", function () {

        if (itemCount === 0) {
            alert("Your cart is empty. Please add at least one dish before placing your order.");
            return;
        }

        let confirmed = confirm("Place your order for \u09F3 " + currentTotal + "?");

        if (confirmed) {
            window.location.href = "../../Controller/place-order.php";
        }

    });

</script>

</body>
</html>