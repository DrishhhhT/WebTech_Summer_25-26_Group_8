<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /project/View/Pages/admin-login.php");
    exit();
}

require_once __DIR__ . "/../Model/db.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int) $_GET['id'];
    $newStatus = ($_GET['status'] === 'open') ? 'open' : 'closed';

    $database = new db();
    $connection = $database->connection();
    $database->toggleCanteenStatus($connection, $id, $newStatus);
}

header("Location: /project/View/Pages/admin-dashboard_canteens.php");
exit();