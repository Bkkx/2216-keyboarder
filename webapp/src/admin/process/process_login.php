<?php

// Start session
session_start();

// Include the config file
$config = include('config.php');

// Create database connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

function display_errorMsg($message) {
    if (!isset($_SESSION['errorMsg'])) {
        $_SESSION['errorMsg'] = [];
    }
    $_SESSION['errorMsg'][] = $message;

}

// Check connection
if ($conn->connect_error) {
    display_errorMsg('Unable to connect to the service, please try again later.');
}


// Retrieve form data
$admin_email = filter_input(INPUT_POST, 'admin_email', FILTER_SANITIZE_EMAIL);
$admin_pwd = filter_input(INPUT_POST, 'admin_pwd', FILTER_SANITIZE_STRING);

// Validate Email
if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
    display_errorMsg('Invalid email format.');
}

// Validate password
if (strlen($admin_pwd) < 8) {
    display_errorMsg('Invalid password format.');
}

// Validate CSRF token
if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    display_errorMsg('CSRF token mismatch');
}

// Unset the CSRF token now that it's been checked
unset($_SESSION['csrf_token']);

// Prepare SQL statement to avoid SQL injection
if ($stmt = $conn->prepare("SELECT * FROM keyboarder.admin WHERE admin_email = ?")) {
    $stmt->bind_param("s", $admin_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($row = $result->fetch_assoc()) {
        // Verify password
        if (password_verify($admin_pwd, $row['admin_password'])) {
            // Set session variables and redirect to a secure page
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['token'] = bin2hex(random_bytes(32)); // Generate a new token
            $_SESSION['token_time'] = time();
            $_SESSION['role'] = "admin";
            $_SESSION['admin_id'] = $row['admin_id'];
            header("Location: ../index.php");
            exit();
        } else {
            // Handle when password is incorrect
            display_errorMsg('Incorrect email or password');
        }
    } else {
        // Handle no user found
        display_errorMsg('Incorrect email or password');
    }
    // Close the statement
    $stmt->close();
}

// If there are errors, redirect back to registration
if (!empty($_SESSION['errorMsg'])) {
    header("Location: ../login.php");
    exit();
}

// Close the connection
$conn->close();
?>