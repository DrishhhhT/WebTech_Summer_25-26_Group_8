<?php
require_once __DIR__ . "/../../Controller/edit_staff_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites - Edit Staff</title>
<link rel="stylesheet" href="../Design/Design_student_login.css">
</head>
<body class="dashboard-body">

<div class="dashboard-wrapper">

    <div class="sidebar">
        <h2 class="sidebar-title">AIUBites</h2>
        <p class="sidebar-subtitle">Admin Panel</p>
        <nav>
        <a href="admin-dashboard_users.php" class="nav-link active">Manage Users</a>
        <a href="admin-dashboard_canteens.php" class="nav-link">Canteens</a>
        <a href="admin-dashboard_orders.php" class="nav-link">Orders</a>
        </nav>
        <a href="admin-login.php" class="logout-link">Logout</a>
    </div>

    <div class="main-content">
        <section class="dashboard-section">
            <h1>Edit Staff — <?php echo htmlspecialchars($staff['unique_id']); ?></h1>

            <form class="inline-form" method="POST" action="edit-staff.php?id=<?php echo $id; ?>">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($staff['name']); ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>">

                <label for="canteen_id">Assigned Canteen</label>
                <select id="canteen_id" name="canteen_id">
                    <option value="">Unassigned</option>
                    <?php while ($c = $canteens->fetch_assoc()) { ?>
                        <option value="<?php echo $c['id']; ?>" <?php echo ($staff['canteen_id'] == $c['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c['name']); ?>
                        </option>
                    <?php } ?>
                </select>

                <input type="submit" value="Save Changes">
                <p class="error-msg"><?php echo $message; ?></p>
            </form>
        </section>
    </div>
</div>

</body>
</html>