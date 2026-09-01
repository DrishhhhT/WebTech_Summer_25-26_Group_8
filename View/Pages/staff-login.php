<?php
include "../../Controller/staff_login_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites - Staff Login</title>
<link rel="stylesheet" href="../Design/Design_student_login.css">

<script>
function collect_data() {

    let staffId = document.getElementById("staffid").value.trim();
    let password = document.getElementById("password").value.trim();
    let valid = true;

    if (staffId === "") {
        document.getElementById("staffid-error").innerHTML = "Staff ID cannot be empty!";
        valid = false;
    }
    else {
        document.getElementById("staffid-error").innerHTML = "";
    }

    if (password === "") {
        document.getElementById("password-error").innerHTML = "Password cannot be empty!";
        valid = false;
    }
    else {
        document.getElementById("password-error").innerHTML = "";
    }

    return valid;
}
</script>

</head>
<body>

<div class="page-wrapper">

    <!-- Header -->
    <header class="site-header">
        <div class="logo">
            <span class="logo-text">AIUB<span class="logo-highlight">ites</span></span>
        </div>
    </header>

    <!-- Main content -->
    <main class="page-main">
        <div class="login-box">

            <h1>AIUBites</h1>
            <p class="subtitle">Staff Login</p>

            <form method="post" action="" onsubmit="return collect_data()">
                <label for="staffid">Staff ID</label>
                <input type="text" id="staffid" name="staffid" placeholder="Enter your Staff ID">
                <p id="staffid-error"></p>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your Password">
                <p id="password-error"></p>

                <input type="submit" id="submit" name="submit" value="Login">
            </form>

            <p class="error-msg"><?php echo $message; ?></p>

            <div class="staff-admin-row">
                <input type="button" class="mini-btn" value="Student Login" onclick="window.location.href='student_login.php'">
                <input type="button" class="mini-btn" value="Admin Login" onclick="window.location.href='admin-login.php'">
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <p class="footer-copy">&copy; 2026 AIUBites. Built for AIUB students.</p>
    </footer>

</div>

</body>
</html>