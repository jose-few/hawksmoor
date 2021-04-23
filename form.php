<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers - UbuyFromMe.com</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<?php
require 'functions.php';
require 'db_info.php';

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

$customer = new Customer();
?>
<body>
    <div>
        <h2>Current Customers:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address(es)</th>
            </tr>
            <?php customerTable($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) ?>
        </table>
        <h2>Select a customer from the dropdown to modify, or add a new customer:</h2>
        <form action="modifyCustomer.php" method="post">
            <?php loadCustomers($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) ?>
            <input type="submit" value="Select This Customer">
        </form>
        <br>
        <h2>Add customer:</h2>
        <form action="sendUpdate.php" method="post">
            <label for="cusname">Customer Name:</label><br>
            <input type="text" id="newcusname" name="newcusname" required><br>
            <label for="cusemail">Customer Email:</label><br>
            <input type="text" id="newcusemail" name="newcusemail" required><br>
            <input type="submit" value="Add Customer">
        </form>
    </div>
</body>
</html>
