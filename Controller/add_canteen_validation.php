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

$canteenName = "";
$canteenLocation = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["canteenname"])) {
    $canteenName = trim($_POST["canteenname"] ?? "");
    $canteenLocation = trim($_POST["canteenlocation"] ?? "");
    $valid = true;

    if (empty($canteenName) || strlen($canteenName) < 3) {
        $message = "Canteen name must be at least 3 characters";
        $valid = false;
    }
    if (empty($canteenLocation)) {
        $message = "Location cannot be empty";
        $valid = false;
    }

    if ($valid) {
        $check = $database->checkDuplicateCanteen($connection, $canteenName);

        if ($check->num_rows > 0) {
            $message = "A canteen with this name already exists";
        } else {
            $result = $database->addCanteen($connection, $canteenName, $canteenLocation);
            if ($result) {
                header("Location: admin-dashboard_canteens.php");
                exit();
            } else {
                $message = "Please try again";
            }
        }
    }
}

$canteens = $database->getAllCanteens($connection);
