<?php
include __DIR__ . "/../Model/db.php";
session_start();

$studentId = "";
$password = "";
$message = "";
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentId = trim($_POST["studentid"] ?? "");
    $password = trim($_POST["password"] ?? "");

    $idPattern = '/^\d{2}-\d{5}-\d$/';

    if (empty($studentId) || !preg_match($idPattern, $studentId)) {
        $message = "Please enter a valid Student ID";
        $valid = false;
    }
    else if (empty($password)) {
        $message = "Password cannot be empty";
        $valid = false;
    }

    if ($valid) {
        $database = new db();
        $connection = $database->connection();

        $result = $database->signin($connection, "users", $studentId, $password, "student");

        if ($result !== false) {

            $_SESSION = array();
            session_regenerate_id(true);

            $_SESSION["logged_in"] = true;
            $_SESSION["student_id"] = $result['id'];
            $_SESSION["name"] = $result['name'];
            $_SESSION["role"] = "student";

            header("Location: student_dashboard_home.php");
            exit();
        } else {
            $message = "Incorrect Student ID or Password";
        }
    }
}