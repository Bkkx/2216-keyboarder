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
$customer_fname = $_POST['customer_fname'];
$customer_lname = $_POST['customer_lname'];
$customer_email = $_POST['customer_email'];
$customer_address = $_POST['customer_address'];
$customer_number = $_POST['customer_number'];
$customer_pwd = $_POST['customer_pwd'];
$confirm_pwd = $_POST['confirm_pwd'];
$customer_points = $_POST['customer_points'];
$customer_join_date = $_POST['customer_join_date'];

// Validate form data
if ($customer_pwd !== $confirm_pwd) {
    $_SESSION['errorMsg'] = "Passwords do not match.";
    header("Location: register.php");
    exit();
}

// Check if email is already in use
$sql = "SELECT * FROM keyboarder.customer WHERE customer_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $customer_email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $_SESSION['errorMsg'] = "Email is already in use.";
    header("Location: register.php");
    exit();
}

// Insert the data into the customer table
$sql = "INSERT INTO keyboarder.customer (customer_fname, customer_lname, customer_email, customer_address, customer_number, customer_password, customer_points, customer_joindate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisss", $customer_fname, $customer_lname, $customer_email, $customer_address, $customer_number, $customer_pwd, $customer_points, $customer_join_date);

if ($stmt->execute()) {
    $_SESSION['successMsg'] = "Registration successful. You can now log in.";
    header("Location: login.php");
} else {
    $_SESSION['errorMsg'] = "Error: " . $stmt->error;
    header("Location: register.php");
}

// Close the connection
$conn->close();
?>