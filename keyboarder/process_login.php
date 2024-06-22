<?php
// Start session
session_start();

// Include the config file
$config = include('process/config.php');

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
    // User found, set session variables and redirect to a secure page
    $_SESSION['customer_email'] = $customer_email;
    header("Location: index.php"); // Redirect to a secure page, e.g., dashboard.php
    exit();
} else {
    // Invalid credentials
    $_SESSION['errorMsg'] = "Invalid email or password.";
    header("Location: login.php");
    exit();
}

// Close the connection
$conn->close();
?>