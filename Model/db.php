<?php
class db{
    
    function connection()
    {
        $db_host="localhost";
        $db_user="root";
        $db_password="";
        $db_name="aiubites";
        $connection= new mysqli($db_host, $db_user, $db_password, $db_name);
        if($connection->connect_error)
            {
                die("Please Connect the Database");
            }
        return $connection;
    }

    function signup($connection, $tablename, $unique_id, $name, $email, $password, $role)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql="INSERT INTO ".$tablename."(unique_id, name, email, password, role) VALUES ('".$unique_id."', '".$name."', '".$email."', '".$hashed."', '".$role."')";
        $result=$connection->query($sql);
        return $result;
    }

    function signin($connection, $tablename, $unique_id, $password, $role)
    {
        $sql="SELECT * FROM ".$tablename." WHERE unique_id = '".$unique_id."' AND role = '".$role."'";
        $result=$connection->query($sql);

        if($result !== false && $result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password']))
                    {
                        return $row;
                    }
            }
        return false;
    }

    function checkDuplicate($connection, $tablename, $unique_id)
    {
        $sql="SELECT * FROM ".$tablename." WHERE unique_id = '".$unique_id."'";
        $result=$connection->query($sql);
        return $result;
    }

    function getUsersByRole($connection, $tablename, $role)
    {
        $sql="SELECT * FROM ".$tablename." WHERE role = '".$role."'";
        $result=$connection->query($sql);
        return $result;
    }

    function updateStatus($connection, $tablename, $id, $newStatus)
    {
        $sql="UPDATE ".$tablename." SET status = '".$newStatus."' WHERE id = ".$id;
        $result=$connection->query($sql);
        return $result;
    }

    function getAllCanteens($connection)
    {
        $sql = "SELECT * FROM canteens";
        return $connection->query($sql);
    }

    function checkDuplicateCanteen($connection, $name)
    {
       $stmt = $connection->prepare("SELECT * FROM canteens WHERE name = ?");
       $stmt->bind_param("s", $name);
       $stmt->execute();
       return $stmt->get_result();
    }

    function addCanteen($connection, $name, $location)
    {
       $stmt = $connection->prepare("INSERT INTO canteens (name, location) VALUES (?, ?)");
       $stmt->bind_param("ss", $name, $location);
       return $stmt->execute();
    }

function toggleCanteenStatus($connection, $id, $newStatus)
{
    $stmt = $connection->prepare("UPDATE canteens SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $id);
    return $stmt->execute();
}

function getMenuItemsByCanteen($connection, $canteen_id)
{
    $stmt = $connection->prepare("SELECT * FROM menu_items WHERE canteen_id = ?");
    $stmt->bind_param("i", $canteen_id);
    $stmt->execute();
    return $stmt->get_result();
}

function addMenuItem($connection, $canteen_id, $name, $price)
{
    $stmt = $connection->prepare("INSERT INTO menu_items (canteen_id, name, price, availability) VALUES (?, ?, ?, 'available')");
    $stmt->bind_param("isd", $canteen_id, $name, $price);
    return $stmt->execute();
}

function toggleMenuItemStatus($connection, $id, $newStatus)
{
    $stmt = $connection->prepare("UPDATE menu_items SET availability = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $id);
    return $stmt->execute();
}

function updateMenuItem($connection, $id, $name, $price)
{
    $stmt = $connection->prepare("UPDATE menu_items SET name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("sdi", $name, $price, $id);
    return $stmt->execute();
}

function deleteMenuItem($connection, $id)
{
    $stmt = $connection->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getAvailableMenuItems($connection, $canteen_id)
{
    $stmt = $connection->prepare("SELECT * FROM menu_items WHERE canteen_id = ? AND availability = 'available'");
    $stmt->bind_param("i", $canteen_id);
    $stmt->execute();
    return $stmt->get_result();
}
function getMenuItemsByIds($connection, $ids)
{
    if (empty($ids)) {
        return null;
    }

    $placeholders = implode(",", array_fill(0, count($ids), "?"));
    $types = str_repeat("i", count($ids));

    $stmt = $connection->prepare("SELECT * FROM menu_items WHERE id IN ($placeholders)");
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    return $stmt->get_result();
}
function addToCart($connection, $student_id, $menu_item_id, $qty)
{
    $stmt = $connection->prepare(
        "INSERT INTO cart_items (student_id, menu_item_id, quantity)
         VALUES (?, ?, ?)
         ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)"
    );
    $stmt->bind_param("iii", $student_id, $menu_item_id, $qty);
    return $stmt->execute();
}

function getCartItems($connection, $student_id)
{
    $stmt = $connection->prepare(
        "SELECT menu_items.id AS id, menu_items.name, menu_items.price, cart_items.quantity
         FROM cart_items
         JOIN menu_items ON cart_items.menu_item_id = menu_items.id
         WHERE cart_items.student_id = ?"
    );
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    return $stmt->get_result();
}

function removeCartItem($connection, $student_id, $menu_item_id)
{
    $stmt = $connection->prepare("DELETE FROM cart_items WHERE student_id = ? AND menu_item_id = ?");
    $stmt->bind_param("ii", $student_id, $menu_item_id);
    return $stmt->execute();
}

function clearCart($connection, $student_id)
{
    $stmt = $connection->prepare("DELETE FROM cart_items WHERE student_id = ?");
    return $stmt->execute();
}

function placeOrder($connection, $student_id, $canteen_id, $cartItems, $total)
{
    $stmt = $connection->prepare(
        "INSERT INTO orders (student_id, canteen_id, total_amount, payment_method, status)
         VALUES (?, ?, ?, 'cash_on_delivery', 'pending')"
    );
    $stmt->bind_param("iid", $student_id, $canteen_id, $total);
    $stmt->execute();

    $orderId = $connection->insert_id;

    $itemStmt = $connection->prepare(
        "INSERT INTO order_items (order_id, menu_item_id, quantity, price_at_order)
         VALUES (?, ?, ?, ?)"
    );

    foreach ($cartItems as $item) {
        $itemStmt->bind_param("iiid", $orderId, $item['id'], $item['qty'], $item['price']);
        $itemStmt->execute();
    }

    return $orderId;
}

function getOrderHistory($connection, $student_id)
{
    $stmt = $connection->prepare(
        "SELECT orders.id AS order_id, orders.total_amount, orders.status, orders.created_at,
                GROUP_CONCAT(menu_items.name, ' x', order_items.quantity SEPARATOR ', ') AS items
         FROM orders
         JOIN order_items ON orders.id = order_items.order_id
         JOIN menu_items ON order_items.menu_item_id = menu_items.id
         WHERE orders.student_id = ?
         GROUP BY orders.id
         ORDER BY orders.created_at DESC"
    );
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getOrdersByCanteen($connection, $canteen_id)
{
    $stmt = $connection->prepare(
        "SELECT orders.id AS order_id, orders.total_amount, orders.status, orders.created_at,
                users.name AS customer_name,
                GROUP_CONCAT(menu_items.name, ' x', order_items.quantity SEPARATOR ', ') AS items
         FROM orders
         JOIN users ON orders.student_id = users.id
         JOIN order_items ON orders.id = order_items.order_id
         JOIN menu_items ON order_items.menu_item_id = menu_items.id
         WHERE orders.canteen_id = ?
         GROUP BY orders.id
         ORDER BY orders.created_at DESC"
    );
    $stmt->bind_param("i", $canteen_id);
    $stmt->execute();
    return $stmt->get_result();
}

function updateOrderStatus($connection, $order_id, $newStatus)
{
    $stmt = $connection->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $order_id);
    return $stmt->execute();
}
function getUserById($connection, $id)
{
    $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateStaffInfo($connection, $id, $name, $email, $canteen_id)
{
    $stmt = $connection->prepare("UPDATE users SET name = ?, email = ?, canteen_id = ? WHERE id = ?");
    $stmt->bind_param("ssii", $name, $email, $canteen_id, $id);
    return $stmt->execute();
}
function getCanteenById($connection, $id)
{
    $stmt = $connection->prepare("SELECT * FROM canteens WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateCanteen($connection, $id, $name, $location, $status)
{
    $stmt = $connection->prepare("UPDATE canteens SET name = ?, location = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $location, $status, $id);
    return $stmt->execute();
}

function deleteCanteen($connection, $id)
{
    $stmt = $connection->prepare("DELETE FROM canteens WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getAllOrders($connection)
{
    $sql = "SELECT orders.id AS order_id, orders.total_amount, orders.status, orders.created_at,
                   users.name AS customer_name,
                   GROUP_CONCAT(menu_items.name, ' x', order_items.quantity SEPARATOR ', ') AS items
            FROM orders
            JOIN users ON orders.student_id = users.id
            JOIN order_items ON orders.id = order_items.order_id
            JOIN menu_items ON order_items.menu_item_id = menu_items.id
            GROUP BY orders.id
            ORDER BY orders.created_at DESC";
    return $connection->query($sql);
}

}