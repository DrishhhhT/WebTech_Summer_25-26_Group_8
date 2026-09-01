<?php
require_once __DIR__ . "/../../Controller/edit_canteen_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites - Edit Canteen</title>
<link rel="stylesheet" href="../Design/Design_student_login.css">
</head>
<body class="dashboard-body">

<div class="dashboard-wrapper">

    <div class="sidebar">
        <h2 class="sidebar-title">AIUBites</h2>
        <p class="sidebar-subtitle">Admin Panel</p>
        <nav>
        <a href="admin-dashboard_users.php" class="nav-link">Manage Users</a>
        <a href="admin-dashboard_canteens.php" class="nav-link active">Canteens</a>
        <a href="admin-dashboard_orders.php" class="nav-link">Orders</a>
        </nav>
        <a href="admin-login.php" class="logout-link">Logout</a>
    </div>

    <div class="main-content">
        <section class="dashboard-section">
            <h1>Edit Canteen — <?php echo htmlspecialchars($canteen['name']); ?></h1>

            <form class="inline-form" method="POST" action="edit-canteen.php?id=<?php echo $id; ?>">
                <label for="name">Canteen Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($canteen['name']); ?>">

                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($canteen['location']); ?>">

                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="open" <?php echo $canteen['status'] === 'open' ? 'selected' : ''; ?>>Open</option>
                    <option value="closed" <?php echo $canteen['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>

                <input type="submit" value="Save Changes">
                <p class="error-msg"><?php echo $message; ?></p>
            </form>
        </section>
    </div>
</div>

</body>
</html>