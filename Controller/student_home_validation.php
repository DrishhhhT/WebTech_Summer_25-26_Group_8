<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'student') {
    header("Location: student_login.php");
    exit();
}

require_once __DIR__ . "/../Model/db.php";

$database = new db();
$connection = $database->connection();


$canteenResult = $database->getAllCanteens($connection);
$allCanteens = array();
if ($canteenResult) {
    while ($c = $canteenResult->fetch_assoc()) {
        $allCanteens[] = $c;
    }
}

if (isset($_GET['canteen_id'])) {
    $requestedId = (int) $_GET['canteen_id'];

    $isValidCanteen = false;
    foreach ($allCanteens as $c) {
        if ((int) $c['id'] === $requestedId) {
            $isValidCanteen = true;
            break;
        }
    }

    if ($isValidCanteen) {
        $_SESSION['canteen_id'] = $requestedId;
    }
}


if (!isset($_SESSION['canteen_id'])) {
    $_SESSION['canteen_id'] = !empty($allCanteens) ? (int) $allCanteens[0]['id'] : 1;
}

$canteenId = $_SESSION['canteen_id'];

$menuItems = $database->getAvailableMenuItems($connection, $canteenId);