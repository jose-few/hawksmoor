<?php

require 'db_info.php';

spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});

function updateCustomer($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $customer = new Customer();
    $customer->set_name($_POST['cusname']);
    $customer->set_email($_POST['cusemail']);
    $customer->set_id($_POST['cusID']);
    $stmt = $con->prepare('UPDATE customers SET name=?, email=? WHERE id=?');
    $stmt->bind_param("sss", $customer->name, $customer->email, $customer->id);
    $stmt->execute();
    $stmt->close();
    $con->close();
}

function addNewAddress($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $customer = new Customer();
    $customer->set_id($_POST['customerID']);
    $stmt = $con->prepare('INSERT INTO addresses (customer, address) VALUES (?, ?)');
    $stmt->bind_param("ss",$customer->id, $_POST['address']);
    $stmt->execute();
    $stmt->close();
    $con->close();
}

function deleteAddress($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $stmt = $con->prepare('DELETE FROM addresses WHERE id = ?');
    $stmt->bind_param("s", $_POST['addresstodelete']);
    $stmt->execute();
    $stmt->close();
    $con->close();
}

function deleteCustomer($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $stmt = $con->prepare('DELETE FROM customers WHERE id = ?');
    $stmt->bind_param("s", $_POST['customertodelete']);
    $stmt->execute();
    $stmt->close();
    $con->close();
}

function addCustomer($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $customer = new Customer();
    $customer->set_name($_POST['newcusname']);
    $customer->set_email($_POST['newcusemail']);
    $stmt = $con->prepare('INSERT INTO customers (name, email) VALUES (?, ?)');
    $stmt->bind_param("ss", $customer->name, $customer->email);
    $stmt->execute();
    $stmt->close();
    $con->close();
}


if ((isset($_POST['newcusname'])) and (isset($_POST['newcusemail']))) {
    addCustomer($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
}

if (isset($_POST['customertodelete'])) {
    deleteCustomer($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
}

if (isset($_POST['addresstodelete'])) {
    deleteAddress($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
}

if (isset($_POST['address'])) {
    addNewAddress($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
}

if ((isset($_POST['cusname'])) and (isset($_POST['cusemail'])) and (isset($_POST['cusID']))) {
    updateCustomer($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
}

header('location: form.php');