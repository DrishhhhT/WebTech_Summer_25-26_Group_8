<?php

include_once __DIR__ . "/../../Controller/MenuManagementValidation.php";

?>

<!DOCTYPE html>

<html>

<head>

    <title>Menu Management</title>

    <link rel="stylesheet"
    href="../Design/MenuManagementStyle.css">

</head>


<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <h2>
        Canteen<br>
        Management
    </h2>

    <a href="IncomingOrders.php">
        Incoming Orders
    </a>

    <a class="active"
    href="MenuManagement.php">
        Menu Management
    </a>

    <a href="DailySales.php">
        Daily Sales
    </a>

    <a href="Settings.php">
        Settings
    </a>

</div>



<!-- MAIN CONTENT -->

<div class="main">

    <h1>Menu Management</h1>


    <!-- ADD / UPDATE MENU -->

    <div class="menu-box">

        <form method="post" action="">

            <input
                type="hidden"
                name="id"
                value="<?php echo $id; ?>"
            >

            <table>

                <tr>

                    <td>
                        Food Name:
                    </td>

                    <td>

                        <input
                            type="text"
                            name="itemname"
                            placeholder="Enter Food Name"
                            value="<?php echo $name; ?>"
                        >

                    </td>

                </tr>


                <tr>

                    <td>
                        Category:
                    </td>

                    <td>

                        <select name="category">

                            <option value="">
                                Select Category
                            </option>

                            <option
                            value="Breakfast"
                            <?php
                            if($category == "Breakfast")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Breakfast
                            </option>

                            <option
                            value="Lunch"
                            <?php
                            if($category == "Lunch")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Lunch
                            </option>

                            <option
                            value="Snacks"
                            <?php
                            if($category == "Snacks")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Snacks
                            </option>

                            <option
                            value="Drinks"
                            <?php
                            if($category == "Drinks")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Drinks
                            </option>

                        </select>

                    </td>

                </tr>


                <tr>

                    <td>
                        Price:
                    </td>

                    <td>

                        <input
                            type="text"
                            name="price"
                            placeholder="Enter Price"
                            value="<?php echo $price; ?>"
                        >

                    </td>

                </tr>


                <tr>

                    <td>
                        Availability:
                    </td>

                    <td>

                        <select name="availability">

                            <option
                            value="Available"
                            <?php
                            if($availability == "Available")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Available
                            </option>

                            <option
                            value="Unavailable"
                            <?php
                            if($availability == "Unavailable")
                            {
                                echo "selected";
                            }
                            ?>
                            >
                                Unavailable
                            </option>

                        </select>

                    </td>

                </tr>


                <tr>

                    <td colspan="2">

                        <?php

                        if($id != "")
                        {

                        ?>

                            <input
                                type="submit"
                                name="updatemenu"
                                value="Update Menu"
                            >

                        <?php

                        }
                        else
                        {

                        ?>

                            <input
                                type="submit"
                                name="addmenu"
                                value="Add Menu"
                            >

                        <?php

                        }

                        ?>


                        <input
                            type="reset"
                            value="Reset"
                        >

                    </td>

                </tr>

            </table>

        </form>


        <p>

            <?php

            echo $message;

            ?>

        </p>

    </div>



    <!-- SEARCH MENU -->

    <div class="search-box">

        <h2>Search Menu</h2>

        <form method="get" action="">

            <input
                type="text"
                name="search"
                placeholder="Search Food or Category"
            >

            <input
                type="submit"
                value="Search"
            >

        </form>

    </div>



    <!-- MENU LIST -->

    <div class="list-box">

        <h2>Menu List</h2>

        <table>

            <tr>

                <th>ID</th>
                <th>Food Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Availability</th>
                <th>Action</th>

            </tr>


            <?php

            if(isset($_GET["search"]))
            {
                $search = $_GET["search"];

                $result = $database->searchMenu(
                    $connection,
                    "menu",
                    $search
                );
            }
            else
            {
                $result = $database->getMenu(
                    $connection,
                    "menu"
                );
            }


            while($row = $result->fetch_assoc())
            {

            ?>

                <tr>

                    <td>

                        <?php
                        echo $row["id"];
                        ?>

                    </td>


                    <td>

                        <?php
                        echo $row["itemname"];
                        ?>

                    </td>


                    <td>

                        <?php
                        echo $row["category"];
                        ?>

                    </td>


                    <td>

                        <?php
                        echo $row["price"];
                        ?>

                    </td>


                    <td>

                        <?php
                        echo $row["availability"];
                        ?>

                    </td>


                    <td>

                        <a
                        class="edit"
                        href="MenuManagement.php?edit=<?php echo $row["id"]; ?>"
                        >
                            Edit
                        </a>


                        <a
                        class="delete"
                        href="MenuManagement.php?delete=<?php echo $row["id"]; ?>"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

            <?php

            }

            ?>

        </table>

    </div>


</div>


</body>

</html>