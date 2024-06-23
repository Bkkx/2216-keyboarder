<?php

// Start session
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
$customer_email = $_POST['customer_email'];
$customer_pwd = $_POST['customer_pwd'];

// Prepare and execute SQL statement
$sql = "SELECT * FROM keyboarder.customer WHERE customer_email = ? AND customer_password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $customer_email, $customer_pwd);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 1) {
    // User found, fetch the result
    $row = $result->fetch_assoc();
    // User found, set session variables and redirect to a secure page
    $_SESSION['customer_email'] = $row['customer_email'];
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();
    $_SESSION['role'] = "customer"; //setting role of user session to customer. to verify is logged in and is user to make some website unaccessible
    $_SESSION['customer_id'] = $row['customer_id'];
    header("Location: ../index.php"); // Redirect to a secure page, e.g., dashboard.php
    exit();
} else {
    // Invalid credentials
    $_SESSION['errorMsg'] = "Invalid email or password.";
    header("Location: ../login.php");
    exit();
}

// Close the connection
$conn->close();
?>