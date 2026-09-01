<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'staff') {
    header("Location: staff-login.php");
    exit();
}

require_once __DIR__ . "/../Model/db.php";

$database = new db();
$connection = $database->connection();

$canteenId = $_SESSION['canteen_id'] ?? 1;

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["itemname"])) {
    $valid = true;

    $itemName = trim($_POST["itemname"] ?? "");
    $itemPrice = trim($_POST["itemprice"] ?? "");

    if (empty($itemName) || strlen($itemName) < 2) {
        $message = "Item name must be at least 2 characters";
        $valid = false;
    }
    if (!is_numeric($itemPrice) || $itemPrice <= 0) {
        $message = "Price must be a valid number";
        $valid = false;
    }

    if ($valid) {
        $result = $database->addMenuItem($connection, $canteenId, $itemName, $itemPrice);
        if ($result) {
            header("Location: staff_dashboard_home.php");
            exit();
        } else {
            $message = "Please try again";
        }
    }
}

$menuItems = $database->getMenuItemsByCanteen($connection, $canteenId);