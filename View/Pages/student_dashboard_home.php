<?php
require_once __DIR__ . "/../../Controller/student_home_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AIUBites — Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Design/student_home.css">
</head>
<body>

    <div class="page-wrapper">

        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-name"><?php echo htmlspecialchars($_SESSION['name']); ?></div>
            </div>

            <nav class="sidebar-nav">
                <a href="student_dashboard_home.php" class="side-link active">Home</a>
                <a href="student_dashboard_OrderHistory.php" id="orderHistoryLink" class="side-link">Order History</a>
                <a href="student_dashboard_cart.php" id="cartLink" class="side-link">Cart</a>
                <a href="student_logout.php" id="logoutLink" class="side-link">Logout</a>
            </nav>
        </aside>

        <div id="screen-wrap">
            <div class="home-hero">
                <h1>WelCome To AIUBites, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
            
            </div>

            <div class="canteen-select-row">
                <label for="canteenSelect" class="canteen-select-label">Canteen</label>
                <select id="canteenSelect" class="canteen-select">
                    <?php foreach ($allCanteens as $c) { ?>
                        <option value="<?php echo (int) $c['id']; ?>" <?php echo ((int) $c['id'] === (int) $canteenId) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c['name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="menu-filter">

                <div class="tabs-row">
                    <span class="menu-label"> Today's Hot Menu!!!</span>
                </div>

                <form action="../../Controller/add-to-cart.php" method="POST" id="menuForm">

                    <div class="menu-list">
                        <?php if ($menuItems && $menuItems->num_rows > 0) { ?>
                            <?php while ($row = $menuItems->fetch_assoc()) { ?>
                                <div class="menu-row" data-id="<?php echo $row['id']; ?>">

                                    <div class="info">
                                        <div class="name"><?php echo htmlspecialchars($row['name']); ?></div>
                                    </div>

                                    <span class="price">৳ <?php echo htmlspecialchars($row['price']); ?></span>

                                    <div class="qty-stepper">
                                        <button type="button" class="qty-btn qty-minus">-</button>
                                        <span class="qty-value">0</span>
                                        <button type="button" class="qty-btn qty-plus">+</button>
                                    </div>

                                    <input
                                        type="hidden"
                                        name="qty[<?php echo $row['id']; ?>]"
                                        value="0"
                                        class="qty-hidden-input"
                                    >

                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="empty-menu-msg">No items available at this canteen right now.</p>
                        <?php } ?>
                    </div>

                    <div class="add-to-cart-wrap">
                        <button type="submit" id="addToCartBtn" class="add-to-cart-btn">Add to Cart</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        let steppers = document.getElementsByClassName("qty-stepper");

        for (let s = 0; s < steppers.length; s++) {
            let stepper = steppers[s];
            let minusBtn = stepper.getElementsByClassName("qty-minus")[0];
            let plusBtn = stepper.getElementsByClassName("qty-plus")[0];
            let hiddenInput = stepper.parentElement.getElementsByClassName("qty-hidden-input")[0];

            minusBtn.addEventListener("click", function () {
                let qtyEl = stepper.getElementsByClassName("qty-value")[0];
                let qty = parseInt(qtyEl.textContent, 10);
                if (qty > 0) {
                    qty = qty - 1;
                    qtyEl.textContent = qty;
                    hiddenInput.value = qty;
                }
            });

            plusBtn.addEventListener("click", function () {
                let qtyEl = stepper.getElementsByClassName("qty-value")[0];
                let qty = parseInt(qtyEl.textContent, 10);
                qty = qty + 1;
                qtyEl.textContent = qty;
                hiddenInput.value = qty;
            });
        }

        let canteenSelect = document.getElementById("canteenSelect");
        canteenSelect.addEventListener("change", function () {
            window.location.href = "student_dashboard_home.php?canteen_id=" + this.value;
        });

        let logoutLink = document.getElementById("logoutLink");
        logoutLink.addEventListener("click", function (e) {
            e.preventDefault();
            let confirmLogout = confirm("Are you sure you want to logout?");
            if (confirmLogout) {
               window.location.href = "student_logout.php";
             }
        });
    </script>

</body>
</html>