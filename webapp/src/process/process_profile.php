<?php
session_start();

// Include the config file
$config = include('config.php');

// Create database connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$customer_id = $_SESSION['customer_id'];
$customer_fname = $_POST['customer_fname'];
$customer_lname = $_POST['customer_lname'];
$customer_address = $_POST['customer_address'];
$customer_number = $_POST['customer_number'];
$change_password = $_POST['change_password'];
$customer_pwd = $_POST['customer_pwd'];
$confirm_pwd = $_POST['confirm_pwd'];

// Validate form data
if ($change_password === "yes" && ($customer_pwd !== $confirm_pwd)) {
    $_SESSION['errorMsg'] = "Passwords do not match.";
    header("Location: ../profile.php");
    exit();
}

// Update the data in the customer table
if ($change_password === "yes") {
    $sql = "UPDATE keyboarder.customer SET customer_fname = ?, customer_lname = ?, customer_address = ?, customer_number = ?, customer_password = ? WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $customer_fname, $customer_lname, $customer_address, $customer_number, $customer_pwd, $customer_id);
} else {
    $sql = "UPDATE keyboarder.customer SET customer_fname = ?, customer_lname = ?, customer_address = ?, customer_number = ? WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $customer_fname, $customer_lname, $customer_address, $customer_number, $customer_id);
}

if ($stmt->execute()) {
    $_SESSION['successMsg'] = "Profile updated successfully.";
    header("Location: ../profile.php");
} else {
    $_SESSION['errorMsg'] = "Error: " . $stmt->error;
    header("Location: ../profile.php");
}

// Close the connection
$stmt->close();
$conn->close();
?>