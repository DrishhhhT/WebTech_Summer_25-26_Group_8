<?php 
include "../../Controller/admin_login_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites - Admin Login</title>
<link rel="stylesheet" href="../Design/Design_student_login.css">

<script>
function collect_data() {

    let adminId = document.getElementById("adminid").value.trim();
    let password = document.getElementById("password").value.trim();
    let valid = true;

    if (adminId === "") {
        document.getElementById("adminid-error").innerHTML = "Admin ID cannot be empty";
        valid = false;
    }
    else if (adminId !== "Admin123") {
        document.getElementById("adminid-error").innerHTML = "Incorrect Admin ID";
        valid = false;
    }
    else {
        document.getElementById("adminid-error").innerHTML = "";
    }

    if (password === "") {
        document.getElementById("password-error").innerHTML = "Password cannot be empty";
        valid = false;
    }
    else if (password !== "Admin123") {
        document.getElementById("password-error").innerHTML = "Incorrect Password";
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
            <p class="subtitle">Admin Portal</p>

            <form method="post" action="" onsubmit="return collect_data()">
                <label for="adminid">Admin ID</label>
                <input type="text" id="adminid" name="adminid" placeholder="Enter your Staff ID">
                <p id="adminid-error"></p>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your Password">
                <p id="password-error"></p>

                <input type="submit" id="submit" name="submit" value="Login">
            </form>

            <p  class="error-msg" ><?php echo $message; ?></p>
            

            <p class="note">Forgot your password? Contact the Information office.</p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <p class="footer-copy">&copy; 2026 AIUBites. Built for AIUB students.</p>
    </footer>

</div>

</body>
</html>