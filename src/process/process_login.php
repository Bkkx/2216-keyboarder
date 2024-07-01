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
    echo htmlspecialchars($message);
}

// Check connection
if ($conn->connect_error) {
    display_errorMsg('Unable to connect to the service, please try again later.');
    exit();
}

// Retrieve form data
$customer_email = filter_input(INPUT_POST, 'customer_email', FILTER_SANITIZE_EMAIL);
$customer_pwd = filter_input(INPUT_POST, 'customer_pwd', FILTER_SANITIZE_STRING);

// Validate Email
if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
    display_errorMsg('Invalid email format.');
    exit();
}

// Validate password
if (strlen($customer_pwd) < 8) {
    display_errorMsg('Invalid password format.');
    exit();
}

// Validate CSRF token
if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    display_errorMsg('CSRF token mismatch');
    exit();
}

// Unset the CSRF token now that it's been checked
unset($_SESSION['csrf_token']);

// Prepare SQL statement to avoid SQL injection
if ($stmt = $conn->prepare("SELECT customer_id, customer_password FROM keyboarder.customer WHERE customer_email = ?")) {
    $stmt->bind_param("s", $customer_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($row = $result->fetch_assoc()) {
        // Verify password
        if (password_verify($customer_pwd, $row['customer_password'])) {
            // Set session variables and return success message
            $_SESSION['customer_email'] = $customer_email;
            $_SESSION['token'] = bin2hex(random_bytes(32)); // Generate a new token
            $_SESSION['token_time'] = time();
            $_SESSION['role'] = "customer";
            $_SESSION['customer_id'] = $row['customer_id'];
            echo "Login successful! Redirecting...";
            exit();
        } else {
            // Handle when password is incorrect
            display_errorMsg('Incorrect email or password');
            exit();
        }
    } else {
        // Handle no user found
        display_errorMsg('Incorrect email or password');
        exit();
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