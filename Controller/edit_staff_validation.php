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

if (!isset($_GET['id'])) {
    header("Location: admin-dashboard_users.php");
    exit();
}

$id = (int) $_GET['id'];
$staff = $database->getUserById($connection, $id);

if (!$staff || $staff['role'] !== 'staff') {
    header("Location: admin-dashboard_users.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $canteenId = !empty($_POST["canteen_id"]) ? (int) $_POST["canteen_id"] : null;

    if (empty($name) || strlen($name) < 5) {
        $message = "Name must be at least 5 characters";
    } elseif (empty($email)) {
        $message = "Email cannot be empty";
    } else {
        $database->updateStaffInfo($connection, $id, $name, $email, $canteenId);
        header("Location: admin-dashboard_users.php");
        exit();
    }
}

$canteens = $database->getAllCanteens($connection);