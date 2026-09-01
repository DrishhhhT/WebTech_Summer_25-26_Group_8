<?php
session_start();

$adminid = "";
$password = "";
$message = "";

$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $adminid = trim($_POST["adminid"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($adminid)) {
        $message = "Admin ID cannot be empty";
        $valid = false;
    }
    else if ($adminid !== "Admin123") {
        $message = "Incorrect Admin ID";
        $valid = false;
    }

    if (empty($password)) {
        $message = "Password cannot be empty";
        $valid = false;
    }
    else if ($password !== "Admin123") {
        $message = "Incorrect Password";
        $valid = false;
    }

    if ($valid) {
        $_SESSION["logged_in"] = true;
        $_SESSION["admin_id"] = $adminid;
        $_SESSION["role"] = "admin";

        header("Location: admin-dashboard_users.php");
        exit();
    }
}
