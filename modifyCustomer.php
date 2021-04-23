<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers - UbuyFromMe.com</title>
</head>
<?php

require 'db_info.php';

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

function searchCustomers($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $stmt = $con->prepare('SELECT name, email FROM customers WHERE id = ?');
    $stmt->bind_param('s', $_POST['customers']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $email);
        echo "<form action='sendUpdate.php' method='post'>";
        while ($stmt->fetch()) {
            $customer = new Customer();
            $customer->set_id($_POST['customers']);
            $customer->set_name($name);
            $customer->set_email($email);
            echo "<input type='text' id='oldname' name='oldname' value='$customer->name' readonly>";
            echo "<input type='text' id='cusname' name='cusname' placeholder='New Customer Name' required><br>";
            echo "<input type='text' id='oldemail' name='oldemail' value='$customer->email' readonly>";
            echo "<input type='text' id='cusemail' name='cusemail' placeholder='New Customer Email' required><br>";
            echo "<input type='hidden' id='cusID' name='cusID' value='$customer->id' required>";
        }
        echo "<input type='submit' value='Confirm Changes'>";
        echo "</form>";
    }
}


function loadAddresses($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $stmt = $con->prepare('SELECT id, customer, address FROM addresses WHERE customer = ?');
    $stmt->bind_param('s', $_POST['customers']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<select name='addresstodelete'>";
        $stmt->bind_result($id, $customer, $address);
        while ($stmt->fetch()) {
            echo "<option value='$id'>$id: $address</option>";
        }
        echo "</select><br>";
    } else {
        echo "No queries found!";
    }
    $stmt->close();
    $con->close();
}

?>
<body>
<h2>Edit Customer Information:</h2>
<?php searchCustomers($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);?>
<br>
<h2>Add New Address:</h2>
<form action="sendUpdate.php" id="newaddress" method="post">
    <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($_POST['customers'])?>" required>
    <label for="address">New Address:</label><br>
    <textarea id="address" name="address" form="newaddress" required></textarea><br>
    <input type="submit" value="Add New Address">
</form>
<br>
<h2>Delete Address:</h2>
<form action="sendUpdate.php" id="deleteaddress" method="post">
    <?php loadAddresses($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); ?>
    <input type="submit" value="Delete Address">
</form>
<br>
<h2>Delete Customer:</h2>
<form action="sendUpdate.php" id="deletecustomer" method="post">
    <input type="hidden" name="customertodelete" value="<?php echo htmlspecialchars($_POST['customers'])?>" required><br>
    <input type="submit" value="Delete Customer"><br>
    <p>Warning! This Will Delete This Customer, This Is Irreversible!</p>
</form>
</body>
</html>