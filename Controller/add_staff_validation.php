<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}

require_once __DIR__ . "/../Model/db.php";

$database = new db();
$connection = $database->connection();

$staffId = "";
$name = "";
$email = "";
$password = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["newstaffid"])) {
    $valid = true;

    $staffId  = trim($_POST["newstaffid"] ?? "");
    $name     = trim($_POST["newstaffname"] ?? "");
    $email    = trim($_POST["newstaffemail"] ?? "");
    $password = trim($_POST["newstaffpass"] ?? "");

    $idPattern = '/^STF-\d{3}$/';

    if (empty($staffId) || !preg_match($idPattern, $staffId)) {
        $message = "Staff ID must follow the pattern STF-001";
        $valid = false;
    }
    if (empty($name) || strlen($name) < 5) {
        $message = "Name must be at least 5 characters";
        $valid = false;
    }
    if (empty($email)) {
        $message = "Email cannot be empty";
        $valid = false;
    }
    if (empty($password)) {
        $message = "Password cannot be empty";
        $valid = false;
    }

    if ($valid) {
        $check = $database->checkDuplicate($connection, "users", $staffId);
        if ($check->num_rows > 0) {
            $message = "This Staff ID already exists";
        } else {
            $result = $database->signup($connection, "users", $staffId, $name, $email, $password, "staff");
            if ($result) {
                header("Location: admin-dashboard_users.php");
                exit();
            } else {
                $message = "Please try again";
            }
        }
    }
}

$students = $database->getUsersByRole($connection, "users", "student");
$staffMembers = $database->getUsersByRole($connection, "users", "staff");

$canteenResult = $database->getAllCanteens($connection);
$canteenNames = array();
if ($canteenResult) {
    while ($c = $canteenResult->fetch_assoc()) {
        $canteenNames[$c['id']] = $c['name'];
    }
}