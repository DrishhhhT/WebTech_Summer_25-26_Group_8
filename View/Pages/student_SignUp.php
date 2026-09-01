<?php
include "../../Controller/student_signup_validation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Campus Bites - Sign Up</title>
<link rel="stylesheet" href="../Design/Design_student_login.css">

<script>
function collect_data() {

    let studentId = document.getElementById("studentid").value.trim();
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let confirmPassword = document.getElementById("confirmpassword").value.trim();

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

    if (name === "") {
        document.getElementById("name-error").innerHTML = "Full Name cannot be empty!";
        valid = false;
    }
    else if (name.length < 5) {
        document.getElementById("name-error").innerHTML = "Full Name must be at least 5 characters!";
        valid = false;
    }
    else {
        document.getElementById("name-error").innerHTML = "";
    }

    let expectedEmail = studentId + "@student.aiub.edu";

    if (email === "") {
        document.getElementById("email-error").innerHTML = "Email cannot be empty!";
        valid = false;
    }
    else if (email !== expectedEmail) {
        document.getElementById("email-error").innerHTML = "Please enter your AIUB student email!";
        valid = false;
    }
    else {
        document.getElementById("email-error").innerHTML = "";
    }

    if (password === "") {
        document.getElementById("password-error").innerHTML = "Password cannot be empty!";
        valid = false;
    }
    else if (password.length < 5) {
        document.getElementById("password-error").innerHTML = "Password must be at least 6 characters!";
        valid = false;
    }
    else if (password.length > 25) {
        document.getElementById("password-error").innerHTML = "Password cannot be more than 20 characters!";
        valid = false;
    }
    else {
        document.getElementById("password-error").innerHTML = "";
    }

    if (confirmPassword === "") {
        document.getElementById("confirmpassword-error").innerHTML = "Confirm Password cannot be empty!";
        valid = false;
    }
    else if (confirmPassword !== password) {
        document.getElementById("confirmpassword-error").innerHTML = "Password does not match!";
        valid = false;
    }
    else {
        document.getElementById("confirmpassword-error").innerHTML = "";
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
            <p class="subtitle">Create your account to get started!</p>

            <form  method="post" action="" onsubmit="return collect_data()">
                <label for="studentid">Student ID</label>
                <input type="text" id="studentid" name="studentid" placeholder="Enter your Student ID">
                <p id="studentid-error"></p>

                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your Full Name">
                <p id="name-error"></p>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your Email">
                <p id="email-error"></p>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your Password">
                <p id="password-error"></p>

                <label for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Re-enter your Password">
                <p id="confirmpassword-error"></p>

                <input type="submit" id="submit" name="submit" value="Sign Up">
                <p class="error-msg"><?php echo $message; ?></p>
            </form>

            <p class="signup-text">Already have an account?</p>
            <a href="student_login.php" class="signup-btn">Login</a>

        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <p class="footer-copy">&copy; 2026 AIUBites. Built for AIUB students.</p>
    </footer>

</div>

</body>
</html>