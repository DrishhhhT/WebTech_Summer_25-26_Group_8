<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /project/View/Pages/admin-login.php");
    exit();
}

require_once __DIR__ . "/../Model/db.php";

$database = new db();
$connection = $database->connection();

$id = (int) ($_GET['id'] ?? 0);

$database->deleteCanteen($connection, $id);

header("Location: /project/View/Pages/admin-dashboard_canteens.php");
exit();