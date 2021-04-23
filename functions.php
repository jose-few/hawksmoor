<?php

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});


function loadCustomers($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $stmt = $con->prepare('SELECT id, name, email FROM customers');
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<select name='customers'>";
        $stmt->bind_result($id, $name, $email);
        while ($stmt->fetch()) {
            echo "<option value='$id'>$id: $name, $email</option>";
        }
        echo "</select>";
    } else {
        echo "No queries found!";
    }
    $stmt->close();
    $con->close();
}

function customerTable($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $stmt = $con->prepare('SELECT id, name, email FROM customers');
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $email);
        while ($stmt->fetch()) {
            $customer = new Customer();
            $customer->set_id($id);
            $customer->set_name($name);
            $customer->set_email($email);
            $getAdd = $con->prepare('SELECT address FROM addresses WHERE customer=?');
            $getAdd->bind_param('s', $customer->id);
            $getAdd->execute();
            $getAdd->store_result();
            if ($getAdd->num_rows > 0) {
                $getAdd->bind_result($address);
                while ($getAdd->fetch()) {
                    $customer->add_address($address);
                }
            }
            echo "<tr><td>$customer->id</td><td>$customer->name</td><td>$customer->email</td>";
            echo "<td>";
            $customer->get_address();
            echo "</td>";
            echo "</tr>";
            $getAdd->close();
        }
    }
    $stmt->close();
    $con->close();
}