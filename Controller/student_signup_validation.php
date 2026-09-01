<?php
include __DIR__ . "/../Model/db.php";
session_start();

$studentId = "";
$name = "";
$email = "";
$password = "";
$confirmPassword = "";
$message = "";
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentId = trim($_POST["studentid"] ?? "");
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirmPassword = trim($_POST["confirmpassword"] ?? "");

    $idPattern = '/^\d{2}-\d{5}-\d$/';
    $expectedEmail = $studentId . "@student.aiub.edu";

    if (empty($studentId) || !preg_match($idPattern, $studentId)) {
        $message = "Please enter a valid Student ID";
        $valid = false;
    }
    else if (empty($name) || strlen($name) < 5) {
        $message = "Full Name must be at least 5 characters";
        $valid = false;
    }
    else if (empty($email) || $email !== $expectedEmail) {
        $message = "Please use your official AIUB student email";
        $valid = false;
    }
    else if (empty($password) || strlen($password) < 6) {
        $message = "Password must be at least 6 characters";
        $valid = false;
    }
    else if ($password !== $confirmPassword) {
        $message = "Passwords do not match";
        $valid = false;
    }

    if ($valid) {
        $database = new db();
        $connection = $database->connection();

        $check = $database->checkDuplicate($connection, "users", $studentId);

        if ($check->num_rows > 0) {
            $message = "This Student ID is already registered";
        } else {
            $database->signup($connection, "users", $studentId, $name, $email, $password, "student");
            header("Location: student_login.php");
            exit();
        }
    }
}