<?php
require_once __DIR__ . "/../../Controller/add_menu_item_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AIUBites — Staff Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Design/staff_home.css">
</head>
<body>

<div class="page-wrapper">

    <aside class="sidebar">
        <div class="sidebar-name">AIUBites <span class="staff-flag">Staff</span></div>
        <nav class="sidebar-nav">
            <a href="staff_dashboard_orderList.php" id="orderListLink" class="side-link">Order List</a>
        </nav>
        <a href="staff-login.php" class="logout-link">Logout</a>
    </aside>

    <div id="screen-wrap">

        <div class="home-hero">
            <h1>Welcome!</h1>
        </div>

        <div class="menu-list" id="staffMenuList">
            <?php while ($row = $menuItems->fetch_assoc()) { ?>
                <div class="menu-row" data-id="<?php echo $row['id']; ?>">

                    <div class="info">
                        <div class="name"><?php echo htmlspecialchars($row['name']); ?></div>
                    </div>

                    <span class="price"><?php echo htmlspecialchars($row['price']); ?> Tk</span>

                    <div class="action-group">
                        <button type="button" class="action-btn edit-btn">Edit</button>
                        <button type="button" class="action-btn delete-btn">Delete</button>
                    </div>

                </div>
            <?php } ?>
        </div>

        <div class="add-item-section">
            <h3 class="add-item-heading">Add New Item</h3>

            <form class="add-item-form" action="staff_dashboard_home.php" method="POST" onsubmit="return collect_data()">
                <label class="add-item-label" for="newItemName">Item Name</label>
                <input type="text" id="newItemName" name="itemname" class="add-item-input" placeholder="e.g. Chicken Biryani">
                <span class="error-msg" id="itemname-error"></span>

                <label class="add-item-label" for="newItemPrice">Price (Tk)</label>
                <input type="text" id="newItemPrice" name="itemprice" class="add-item-input" placeholder="e.g. 130">
                <span class="error-msg" id="itemprice-error"></span>

                <input type="submit" id="addItemFormBtn" class="add-item-form-btn" value="ADD ITEM">

                <p class="error-msg"><?php echo htmlspecialchars($message); ?></p>
            </form>
        </div>

    </div>
</div>

<script>
    function collect_data() {

        let itemName = document.getElementById("newItemName").value.trim();
        let itemPrice = document.getElementById("newItemPrice").value.trim();
        let valid = true;

        let pricePattern = /^\d+(\.\d{1,2})?$/;

        if (itemName === "") {
            document.getElementById("itemname-error").innerHTML = "Item name cannot be empty!";
            valid = false;
        }
        else if (itemName.length < 2) {
            document.getElementById("itemname-error").innerHTML = "Item name must be valid!";
            valid = false;
        }
        else {
            document.getElementById("itemname-error").innerHTML = "";
        }

        if (itemPrice === "") {
            document.getElementById("itemprice-error").innerHTML = "Price cannot be empty!";
            valid = false;
        }
        else if (!pricePattern.test(itemPrice)) {
            document.getElementById("itemprice-error").innerHTML = "Price must be valid!";
            valid = false;
        }
        else {
            document.getElementById("itemprice-error").innerHTML = "";
        }

        return valid;
    }

    function wireRow(row) {
        let id = row.getAttribute("data-id");

        let deleteBtn = row.getElementsByClassName("delete-btn")[0];
        deleteBtn.addEventListener("click", function () {
            let itemName = row.getElementsByClassName("name")[0].textContent.trim();
            if (confirm("Delete \"" + itemName + "\" from the menu?")) {
                location.href = "../../Controller/delete-item.php?id=" + id;
            }
        });

        let editBtn = row.getElementsByClassName("edit-btn")[0];
        editBtn.addEventListener("click", function () {
            let nameEl = row.getElementsByClassName("name")[0];
            let priceEl = row.getElementsByClassName("price")[0];

            let newName = prompt("Item name:", nameEl.textContent.trim());
            if (newName === null) return;

            let newPrice = prompt("Price (number only):", priceEl.textContent.replace("Tk", "").trim());
            if (newPrice === null) return;

            location.href = "../../Controller/edit-item.php?id=" + id + "&name=" + encodeURIComponent(newName) + "&price=" + encodeURIComponent(newPrice);
        });
    }

    let initialRows = document.getElementsByClassName("menu-row");
    for (let r = 0; r < initialRows.length; r++) {
        wireRow(initialRows[r]);
    }
</script>

</body>
</html>