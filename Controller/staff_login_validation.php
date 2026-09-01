<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../Model/db.php";

$staffId = "";
$password = "";
$message = "";
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $staffId = trim($_POST["staffid"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($staffId)) {
        $message = "Staff ID cannot be empty";
        $valid = false;
    }
    else if (empty($password)) {
        $message = "Password cannot be empty";
        $valid = false;
    }

    if ($valid) {
        $database = new db();
        $connection = $database->connection();

        $result = $database->signin($connection, "users", $staffId, $password, "staff");

        if ($result !== false) {

            $_SESSION = array();
            session_regenerate_id(true);

            $_SESSION["logged_in"] = true;
            $_SESSION["staff_id"] = $result['id'];
            $_SESSION["name"] = $result['name'];
            $_SESSION["role"] = "staff";
            $_SESSION["canteen_id"] = $result['canteen_id'] ?? 1;

            header("Location: staff_dashboard_home.php");
            exit();
        } else {
            $message = "Incorrect Staff ID or Password";
        }
    }
}