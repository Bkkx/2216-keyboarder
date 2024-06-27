<?php

// Start session
session_start();

// Include the config file
$config = include('config.php');

// Create database connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Ensure that errorMsg is an array ready to collect any error messages
if (!isset($_SESSION['errorMsg'])) {
    $_SESSION['errorMsg'] = [];
}

// Check connection
if ($conn->connect_error) {
    $_SESSION['errorMsg'][] = "Connection failed: " . $conn->connect_error;
    header("Location: ../login.php");
    exit();
}

// Retrieve form data
$customer_email = $_POST['customer_email'];
$customer_pwd = $_POST['customer_pwd'];

// Validate CSRF token
if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['errorMsg'][] = 'CSRF token mismatch.';
    header("Location: ../login.php");
    exit();
}

// Unset the CSRF token now that it's been checked
unset($_SESSION['csrf_token']);

// Prepare and execute SQL statement
$stmt = $conn->prepare("SELECT customer_id, customer_password FROM keyboarder.customer WHERE customer_email = ?");
$stmt->bind_param("s", $customer_email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($row = $result->fetch_assoc()) {
    if (password_verify($customer_pwd, $row['customer_password'])) {
         // Password hash matches the one stored in database, set session variables and redirect to a secure page
        $_SESSION['customer_email'] = $row['customer_email'];
        $_SESSION['token'] = $token;
        $_SESSION['token_time'] = time();
        $_SESSION['role'] = "customer"; //setting role of user session to customer. to verify is logged in and is user to make some website unaccessible
        $_SESSION['customer_id'] = $row['customer_id'];
        header("Location: ../index.php"); // Redirect to a secure page, e.g., dashboard.php
        exit();
    } else {
        // Invalid credentials
        $_SESSION['errorMsg'][] = "Invalid email or password.";
        header("Location: ../login.php");
        exit();
    }

}

// Close the connection
$conn->close();
?>