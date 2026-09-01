<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'student') {
    header("Location: /project/View/Pages/student_login.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/project/Model/db.php";

$database = new db();
$connection = $database->connection();

$studentId = $_SESSION['student_id'];
$itemId = (int)($_GET['id'] ?? 0);

$database->removeCartItem($connection, $studentId, $itemId);

header("Location: /project/View/Pages/student_dashboard_cart.php");
exit();