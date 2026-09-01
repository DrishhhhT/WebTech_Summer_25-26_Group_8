<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['logged_in']) || !in_array($_SESSION['role'], array('student', 'staff'))) {
    header("Location: student_login.php");
    exit();
}

require_once __DIR__ . "/../Model/db.php";

$database = new db();
$connection = $database->connection();

$role = $_SESSION['role'];

$statusLabels = array(
    'pending' => 'Pending',
    'preparing' => 'Preparing',
    'ready' => 'Ready',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled'
);

if ($role === 'staff') {

    $canteenId = $_SESSION['canteen_id'] ?? 1;

    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {
        $orderId = (int) $_POST['order_id'];
        $newStatus = $_POST['status'];

        if (array_key_exists($newStatus, $statusLabels)) {
            $database->updateOrderStatus($connection, $orderId, $newStatus);
        }

        header("Location: student_dashboard_OrderHistory.php");
        exit();
    }

    $orders = $database->getOrdersByCanteen($connection, $canteenId);

} else {

    $studentId = $_SESSION['student_id'];
    $orders = $database->getOrderHistory($connection, $studentId);

}

$orderCount = $orders ? $orders->num_rows : 0;
?>