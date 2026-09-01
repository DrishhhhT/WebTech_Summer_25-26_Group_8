<?php
require_once __DIR__ . "/../../Controller/add_staff_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites - Manage Users</title>
<link rel="stylesheet" href="../Design/Design_student_login.css">

<script>
function validateStaffForm() {

    let staffId = document.getElementById("newstaffid").value.trim();
    let staffName = document.getElementById("newstaffname").value.trim();
    let staffEmail = document.getElementById("newstaffemail").value.trim();
    let staffPass = document.getElementById("newstaffpass").value.trim();
    let valid = true;

    let idPattern = /^STF-\d{3}$/;

    if (staffId === "") {
        document.getElementById("newstaffid-error").innerHTML = "Staff ID cannot be empty!";
        valid = false;
    }
    else if (!idPattern.test(staffId)) {
        document.getElementById("newstaffid-error").innerHTML = "Staff ID must follow the pattern STF-001";
        valid = false;
    }
    else {
        document.getElementById("newstaffid-error").innerHTML = "";
    }

    if (staffName === "") {
        document.getElementById("newstaffname-error").innerHTML = "Name cannot be empty!";
        valid = false;
    }
    else if (staffName.length < 5) {
        document.getElementById("newstaffname-error").innerHTML = "Name must be at least 5 characters!";
        valid = false;
    }
    else {
        document.getElementById("newstaffname-error").innerHTML = "";
    }
    if (staffEmail === "") {
        document.getElementById("newstaffemail-error").innerHTML = "Email cannot be empty!";
        valid = false;
    }
    if (staffPass === "") {
        document.getElementById("newstaffpass-error").innerHTML = "Password cannot be empty!";
        valid = false;
    }

    return valid;
}
</script>

</head>
<body class="dashboard-body">

<div class="dashboard-wrapper">

    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="main-content">

        <section class="dashboard-section">
            <h1>Manage User Accounts</h1>


            <!-- Students -->
            <h3>Students</h3>
            <table class="data-table">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php if ($students && $students->num_rows > 0) { ?>
                    <?php while ($row = $students->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['unique_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($row['status'])); ?></td>
                            <td>
                               <a href="../../Controller/deactivate-user.php?id=<?php echo $row['id']; ?>" class="action-link delete">
                                 <?php echo $row['status'] === 'active' ? 'Deactivate' : 'Activate'; ?>
                               </a>
                           </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
            <?php if (!$students || $students->num_rows == 0) { ?>
                <p class="empty-state">No students registered yet.</p>
            <?php } ?>

            <!-- Staff -->
            <h3>Staff</h3>
            <table class="data-table">
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Canteen</th>
                    <th>Action</th>
                </tr>
                <?php if ($staffMembers && $staffMembers->num_rows > 0) { ?>
                    <?php while ($row = $staffMembers->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['unique_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?php
                                    if (!empty($row['canteen_id']) && isset($canteenNames[$row['canteen_id']])) {
                                        echo htmlspecialchars($canteenNames[$row['canteen_id']]);
                                    } else {
                                        echo 'Unassigned';
                                    }
                                ?>
                            </td>
                            <td>
                                <a href="edit-staff.php?id=<?php echo $row['id']; ?>" class="action-link">Edit</a> |
                                <a href="../../Controller/deactivate-user.php?id=<?php echo $row['id']; ?>" class="action-link delete">
                                    <?php echo $row['status'] === 'active' ? 'Remove' : 'Restore'; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
            <?php if (!$staffMembers || $staffMembers->num_rows == 0) { ?>
                <p class="empty-state">No staff accounts created yet.</p>
            <?php } ?>

            <!-- Add Staff -->
            <h3>Add New Staff</h3>
            <form class="inline-form" action="admin-dashboard_users.php" method="POST" onsubmit="return validateStaffForm()">
                <label for="newstaffid">Staff ID</label>
                <input type="text" id="newstaffid" name="newstaffid" placeholder="STF-002">
                <p id="newstaffid-error" class="error-msg"></p>

                <label for="newstaffname">Name</label>
                <input type="text" id="newstaffname" name="newstaffname" placeholder="Full Name">
                <p id="newstaffname-error" class="error-msg"></p>

                <label for="newstaffemail">Email</label>
                <input type="email" id="newstaffemail" name="newstaffemail" placeholder="staff@aiub.edu">
                <p id="newstaffemail-error" class="error-msg"></p>

                <label for="newstaffpass">Password</label>
                <input type="password" id="newstaffpass" name="newstaffpass" placeholder="Set a temporary password">
                <p id="newstaffpass-error" class="error-msg"></p>

                <input type="submit" value="Create Staff Account">

                <p class="error-msg"><?php echo htmlspecialchars($message); ?></p>
            </form>
        </section>

    </div>
</div>

</body>
</html>