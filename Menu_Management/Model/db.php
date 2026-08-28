<?php

class db
{
    function connection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "section_t";

        $connection = new mysqli(
            $db_host,
            $db_user,
            $db_password,
            $db_name
        );

        if($connection->connect_error)
        {
            die("Database Connection Failed");
        }

        return $connection;
    }


    function addMenu(
        $connection,
        $tablename,
        $itemname,
        $category,
        $price,
        $availability
    )
    {
        $sql = "INSERT INTO ".$tablename."
        (itemname, category, price, availability)
        VALUES
        (
            '".$itemname."',
            '".$category."',
            '".$price."',
            '".$availability."'
        )";

        $result = $connection->query($sql);

        return $result;
    }


    function getMenu($connection, $tablename)
    {
        $sql = "SELECT * FROM ".$tablename;

        $result = $connection->query($sql);

        return $result;
    }


    function searchMenu($connection, $tablename, $search)
    {
        $sql = "SELECT * FROM ".$tablename."
        WHERE itemname LIKE '%".$search."%'
        OR category LIKE '%".$search."%'";

        $result = $connection->query($sql);

        return $result;
    }


    function getMenuById($connection, $tablename, $id)
    {
        $sql = "SELECT * FROM ".$tablename."
        WHERE id='".$id."'";

        $result = $connection->query($sql);

        return $result;
    }


    function updateMenu(
        $connection,
        $tablename,
        $id,
        $itemname,
        $category,
        $price,
        $availability
    )
    {
        $sql = "UPDATE ".$tablename."
        SET
        itemname='".$itemname."',
        category='".$category."',
        price='".$price."',
        availability='".$availability."'
        WHERE id='".$id."'";

        $result = $connection->query($sql);

        return $result;
    }


    function deleteMenu($connection, $tablename, $id)
    {
        $sql = "DELETE FROM ".$tablename."
        WHERE id='".$id."'";

        $result = $connection->query($sql);

        return $result;
    }
}

?>