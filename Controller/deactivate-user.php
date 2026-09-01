<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: /project/View/Pages/admin-login.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/project/Model/db.php";

$database = new db();
$connection = $database->connection();

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $user = $database->getUserById($connection, $id);

    if ($user) {
        $newStatus = ($user['status'] === 'active') ? 'inactive' : 'active';
        $database->updateStatus($connection, "users", $id, $newStatus);
    }
}

header("Location: /project/View/Pages/admin-dashboard_users.php");
exit();