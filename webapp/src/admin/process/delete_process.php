<?php

session_start();

// Include the configuration file
$config = require 'config.php';

// Ensure there is a logged-in admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Create a new mysqli object with the configuration parameters
$conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
);
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    echo "<script>alert('$errorMsg'); window.history.go(-1);</script>";
    exit;
}

$admin_id = $_SESSION['admin_id'];
$admin_pwd = filter_input(INPUT_POST, 'admin_pwd', FILTER_SANITIZE_STRING);

// Retrieve the hashed password from the database for the logged-in admin
$stmt = $conn->prepare("SELECT admin_password FROM keyboarder.admin WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id); // Assuming the admin ID is stored in session
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (!password_verify($admin_pwd, $row['admin_password'])) {
        echo "<script>alert('Incorrect admin password.'); window.history.go(-1);</script>";
        exit;  // Ensure script stops executing if password is incorrect
    }
} else {
    echo "<script>alert('Admin user not found.'); window.history.go(-1);</script>";
    exit;  // Stop execution if no admin is found
}

$stmt->close();


// Check for the entity to be deleted
if (isset($_GET['customerid'])) {
    $customer_id = $_POST['customer_id'];
    handleDeletion('customer', $customer_id, $conn);
} elseif (isset($_GET['productid'])) {
    $product_id = $_POST['product_id'];
    handleDeletion('product', $product_id, $conn);
} elseif (isset($_GET['orderid'])) {
    $order_id = $_POST['order_id'];
    handleDeletion('order', $order_id, $conn);
}


function handleDeletion($type, $id, $mysqli) {
    $stmt = mysqli_prepare($mysqli, "DELETE FROM `$type` WHERE `${type}_id` = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $affected_rows = mysqli_stmt_affected_rows($stmt);

    if ($affected_rows > 0) {
        echo "<script>alert('Delete successful. {$affected_rows} rows affected.'); window.location.href = '../{$type}list.php';</script>";
    } else {
        echo "<script>alert('Delete failed. No rows affected.'); window.location.href = '../{$type}list.php';</script>";
    }
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>

