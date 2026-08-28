<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" href="../Design/SettingsStyle.css">
</head>

<body>


<div class="sidebar">

    <h1>AIUBites</h1>

    <a href="IncomingOrders.php">Incoming Orders</a>

    <a href="MenuManagement.php">
        Menu Management
    </a>

    <a href="DailySales.php">
        Daily Sales
    </a>

    <a class="active" href="Settings.php">
        Settings
    </a>

</div>



<div class="main">

    <div class="header">

        <h1>Settings</h1>

        <p>Manage Your Canteen Information</p>

    </div>



    <div class="settings-container">

        <h2>Canteen Information</h2>


        <form>

            <table>


                <tr>

                    <td>
                        <label for="canteenname">
                            Canteen Name
                        </label>
                    </td>

                    <td>

                        <input type="text"
                        id="canteenname"
                        name="canteenname"
                        placeholder="Enter Canteen Name">

                    </td>

                </tr>



                <tr>

                    <td>

                        <label for="email">
                            Email
                        </label>

                    </td>

                    <td>

                        <input type="text"
                        id="email"
                        name="email"
                        placeholder="Enter Email">

                    </td>

                </tr>



                <tr>

                    <td>

                        <label for="phone">
                            Phone Number
                        </label>

                    </td>

                    <td>

                        <input type="text"
                        id="phone"
                        name="phone"
                        placeholder="Enter Phone Number">

                    </td>

                </tr>



                <tr>

                    <td>

                        <label for="address">
                            Address
                        </label>

                    </td>

                    <td>

                        <textarea
                        id="address"
                        rows="5"
                        cols="25"
                        placeholder="Enter Address">
                        </textarea>

                    </td>

                </tr>



                <tr>

                    <td colspan="2">

                        <input type="submit"
                        value="Save Settings">

                        <input type="reset"
                        value="Reset">

                    </td>

                </tr>


            </table>

        </form>

    </div>



    <div class="password">

        <h2>Change Password</h2>

        <form>

            <table>

                <tr>

                    <td>
                        <label for="oldpassword">
                            Old Password
                        </label>
                    </td>

                    <td>

                        <input type="password"
                        id="oldpassword"
                        name="oldpassword">

                    </td>

                </tr>


                <tr>

                    <td>

                        <label for="newpassword">
                            New Password
                        </label>

                    </td>

                    <td>

                        <input type="password"
                        id="newpassword"
                        name="newpassword">

                    </td>

                </tr>


                <tr>

                    <td>

                        <label for="confirmpassword">
                            Confirm Password
                        </label>

                    </td>

                    <td>

                        <input type="password"
                        id="confirmpassword"
                        name="confirmpassword">

                    </td>

                </tr>


                <tr>

                    <td colspan="2">

                        <input type="submit"
                        value="Change Password">

                    </td>

                </tr>

            </table>

        </form>

    </div>

</div>

</body>
</html>