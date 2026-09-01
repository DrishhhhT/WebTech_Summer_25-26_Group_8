<?php
require_once __DIR__ . "/../../Controller/add_canteen_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Campus Bites - Canteens</title>
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
            <h1>Manage Canteens</h1>


            <table class="data-table">
                <tr>
                    <th>Canteen Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php if ($canteens && $canteens->num_rows > 0) { ?>
                    <?php while ($row = $canteens->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($row['status'])); ?></td>
                            <td>
                                <a href="edit-canteen.php?id=<?php echo $row['id']; ?>" class="action-link">Edit</a> |
                                <a href="../../Controller/delete-canteen.php?id=<?php echo $row['id']; ?>" class="action-link delete" onclick="return confirm('Delete this canteen? This cannot be undone.');">Remove</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
            <?php if (!$canteens || $canteens->num_rows == 0) { ?>
                <p class="empty-state">No canteens added yet.</p>
            <?php } ?>

            <h3>Add New Canteen</h3>
            <form class="inline-form" action="admin-dashboard_canteens.php" method="POST">
                <label for="canteenname">Canteen Name</label>
                <input type="text" id="canteenname" name="canteenname" placeholder="Canteen 1" value="<?php echo htmlspecialchars($canteenName); ?>">

                <label for="canteenlocation">Location</label>
                <input type="text" id="canteenlocation" name="canteenlocation" placeholder="e.g. 2nd Floor, Building C" value="<?php echo htmlspecialchars($canteenLocation); ?>">

                <input type="submit" value="Add Canteen">

                <p class="error-msg"><?php echo htmlspecialchars($message); ?></p>
            </form>
        </section>

    </div>
</div>

</body>
</html>