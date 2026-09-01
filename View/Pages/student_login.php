<?php
include "../../Controller/student_login_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>AIUBites - Login</title>
<link rel="stylesheet" href="../Design/Design_student_login.css">

<script>
function collect_data() {

    let studentId = document.getElementById("studentid").value.trim();
    let password = document.getElementById("password").value.trim();
    let valid = true;

    
    let idPattern = /^\d{2}-\d{5}-\d$/;

    if (studentId === "") {
        document.getElementById("studentid-error").innerHTML = "Student ID cannot be empty!";
        valid = false;
    }
    else if (!idPattern.test(studentId)) {
        document.getElementById("studentid-error").innerHTML = "Student ID must be valid!";
        valid = false;
    }
    else {
        document.getElementById("studentid-error").innerHTML = "";
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
            <p class="subtitle">Order food. Skip the queue!</p>

            <form  method= "post" action="" onsubmit="return collect_data()">
                <label for="studentid">Student ID</label>
                <input type="text" id="studentid" name="studentid" placeholder="Enter your Student ID">
                <p id="studentid-error"></p>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your Password">
                <p id="password-error"></p>


                <input type="submit" id="submit" name="submit" value="Login">
            </form>

            <p class="error-msg"><?php echo $message; ?></p>

            <div class="divider">
                <span>OR</span>
            </div>

            <p class="signup-text">Don't have an account?</p>
            <a href="student_SignUp.php" class="signup-btn">Sign Up</a>

             <div class="staff-admin-row">
          <input type="button" class="mini-btn" value="Admin Login" onclick="window.location.href='admin-login.php'">
          <input type="button" class="mini-btn" value="Staff Login" onclick="window.location.href='staff-login.php'">
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