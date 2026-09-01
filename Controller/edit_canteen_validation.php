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
    header("Location: admin-dashboard_canteens.php");
    exit();
}

$id = (int) $_GET['id'];
$canteen = $database->getCanteenById($connection, $id);

if (!$canteen) {
    header("Location: admin-dashboard_canteens.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $status = $_POST["status"] ?? "open";

    $allowedStatuses = array('open', 'closed');

    if (empty($name) || strlen($name) < 3) {
        $message = "Canteen name must be at least 3 characters";
    } elseif (empty($location)) {
        $message = "Location cannot be empty";
    } elseif (!in_array($status, $allowedStatuses)) {
        $message = "Invalid status selected";
    } else {
        $database->updateCanteen($connection, $id, $name, $location, $status);
        header("Location: admin-dashboard_canteens.php");
        exit();
    }
}