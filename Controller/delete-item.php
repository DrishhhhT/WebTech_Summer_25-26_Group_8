<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'staff') {
    header("Location: /project/View/Pages/staff-login.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/project/Model/db.php";

$database = new db();
$connection = $database->connection();

$id = (int) ($_GET['id'] ?? 0);
$database->deleteMenuItem($connection, $id);

header("Location: /project/View/Pages/staff_dashboard_home.php");
exit();