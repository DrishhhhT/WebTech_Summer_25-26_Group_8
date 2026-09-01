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

$studentId = $_SESSION['student_id'];
$serviceFeeAmount = 10;

$result = $database->getCartItems($connection, $studentId);

$cartItems = array();
$subtotal = 0;

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $lineTotal = $row['price'] * $row['quantity'];
        $subtotal += $lineTotal;

        $cartItems[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'qty' => $row['quantity'],
            'lineTotal' => $lineTotal
        );
    }
}

$itemCount = count($cartItems);
$fee = $itemCount > 0 ? $serviceFeeAmount : 0;
$total = $subtotal + $fee;