<?php

session_start();

$success = true;
// Include the configuration file
$config = require 'config.php';

// Create a new mysqli object with the configuration parameters
$conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
);

if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    echo($errorMsg);
}

$admin_id = $_SESSION['admin_id'];
$admin_pwd = $_POST['admin_pwd'];

$sql = "SELECT admin_password FROM keyboarder.admin WHERE admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$hashed_password = $result->fetch_assoc()['admin_password'];

if (!password_verify($admin_pwd, $hashed_password)) {
    echo "<script>alert('Invalid Admin Password'); history.go(-1);</script>";
    exit;
}

// Using isset to check if the keys exist
if (isset($_GET['productid'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_cost = $_POST['product_cost'];
    $category_id = $_POST['category_id'];
    $product_sd = $_POST['product_sd'];
    $product_ld = $_POST['product_ld'];
    $product_quantity = $_POST['product_quantity'];

    $stmt = $conn->prepare("UPDATE product SET
        product_name = ?,
        product_cost = ?,
        category_id = ?,
        product_sd = ?,
        product_ld = ?,
        product_quantity = ?
        WHERE product_id = ?");

    $stmt->bind_param("ssisssi", $product_name, $product_cost, $category_id, $product_sd, $product_ld, $product_quantity, $product_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Update successful. " . $stmt->affected_rows . " rows affected.'); window.location.href = '../productlist.php';</script>";
    } else {
        echo "<script>alert('Update failed. No rows affected.'); window.location.href = '../productlist.php';</script>";
    }
} elseif (isset($_GET['customerid'])) {
    $customer_id = $_POST['customer_id'];
    $customer_fname = $_POST['customer_fname'];
    $customer_lname = $_POST['customer_lname'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];
    $customer_number = $_POST['customer_number'];

    $stmt = $conn->prepare("UPDATE customer SET
        customer_fname = ?,
        customer_lname = ?,
        customer_email = ?,
        customer_address = ?,
        customer_number = ?
        WHERE customer_id = ?");

    $stmt->bind_param("ssssis", $customer_fname, $customer_lname, $customer_email, $customer_address, $customer_number, $customer_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Update successful. " . $stmt->affected_rows . " rows affected.'); window.location.href = '../userlist.php';</script>";
    } else {
        echo "<script>alert('Update failed. No rows affected.'); window.location.href = '../userlist.php';</script>";
    }
} elseif (isset($_GET['orderid'])) {
    $order_id = $_POST['order_id'];
    $order_tracking_no = $_POST['order_tracking_no'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("UPDATE `order` SET
        order_tracking_no = ?,
        order_status = ?
        WHERE order_id = ?");

    $stmt->bind_param("ssi", $order_tracking_no, $order_status, $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Update successful. " . $stmt->affected_rows . " rows affected.'); window.location.href = '../orderlist.php';</script>";
    } else {
        echo "<script>alert('Update failed. No rows affected.'); window.location.href = '../orderlist.php';</script>";
    }
}

$stmt->close();
$conn->close();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}