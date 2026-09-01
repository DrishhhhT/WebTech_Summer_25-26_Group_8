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
$canteenId = $_SESSION['canteen_id'] ?? 1;
$serviceFeeAmount = 10;

$result = $database->getCartItems($connection, $studentId);

$cartItems = array();
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    $cartItems[] = array(
        'id' => $row['id'],
        'qty' => $row['quantity'],
        'price' => $row['price']
    );
    $subtotal += $row['price'] * $row['quantity'];
}

if (count($cartItems) > 0) {

    $total = $subtotal + $serviceFeeAmount;

    $database->placeOrder($connection, $studentId, $canteenId, $cartItems, $total);
    $database->clearCart($connection, $studentId);

}

header("Location: /project/View/Pages/student_dashboard_OrderHistory.php");
exit();