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
$name = trim($_GET['name'] ?? '');
$price = trim($_GET['price'] ?? '');

if ($name !== '' && is_numeric($price)) {
    $database->updateMenuItem($connection, $id, $name, $price);
}

header("Location: /project/View/Pages/staff_dashboard_home.php");
exit();