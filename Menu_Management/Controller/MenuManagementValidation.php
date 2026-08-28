<?php

include_once __DIR__ . "/../Model/db.php";

$database = new db();
$connection = $database->connection();

$id = "";
$name = "";
$category = "";
$price = "";
$availability = "";

$message = "";


/* ADD MENU */

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["addmenu"]))
    {
        $name = trim($_POST["itemname"] ?? "");
        $category = trim($_POST["category"] ?? "");
        $price = trim($_POST["price"] ?? "");
        $availability = trim($_POST["availability"] ?? "");

        if($name == "")
        {
            $message = "Food Name Required";
        }
        else if($category == "")
        {
            $message = "Category Required";
        }
        else if($price == "")
        {
            $message = "Price Required";
        }
        else
        {
            $result = $database->addMenu(
                $connection,
                "menu",
                $name,
                $category,
                $price,
                $availability
            );

            if($result)
            {
                header("Location: MenuManagement.php");
                exit();
            }
            else
            {
                $message = "Menu Could Not Be Added";
            }
        }
    }
}


/* UPDATE MENU */

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["updatemenu"]))
    {
        $id = $_POST["id"];

        $name = trim($_POST["itemname"] ?? "");
        $category = trim($_POST["category"] ?? "");
        $price = trim($_POST["price"] ?? "");
        $availability = trim($_POST["availability"] ?? "");

        $result = $database->updateMenu(
            $connection,
            "menu",
            $id,
            $name,
            $category,
            $price,
            $availability
        );

        if($result)
        {
            header("Location: MenuManagement.php");
            exit();
        }
    }
}


/* DELETE MENU */

if(isset($_GET["delete"]))
{
    $id = $_GET["delete"];

    $result = $database->deleteMenu(
        $connection,
        "menu",
        $id
    );

    if($result)
    {
        header("Location: MenuManagement.php");
        exit();
    }
}


/* EDIT MENU */

if(isset($_GET["edit"]))
{
    $id = $_GET["edit"];

    $result = $database->getMenuById(
        $connection,
        "menu",
        $id
    );

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        $id = $row["id"];
        $name = $row["itemname"];
        $category = $row["category"];
        $price = $row["price"];
        $availability = $row["availability"];
    }
}

?>