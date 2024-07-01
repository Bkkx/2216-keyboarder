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
$customer_code = filter_input(INPUT_POST, 'customer_code', FILTER_SANITIZE_EMAIL);

// Validate Email

// Validate password
if (strlen($customer_code) !==6) {
    display_errorMsg('Invalid token length.');
}

$customer_email = $_SESSION['customer_email'];
// Validate CSRF token
// if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     display_errorMsg('CSRF token mismatch');
// }

// // Unset the CSRF token now that it's been checked
// unset($_SESSION['csrf_token']);

// Prepare SQL statement to avoid SQL injection
if ($stmt = $conn->prepare("SELECT customer_code FROM keyboarder.customer WHERE customer_email = ?")) {
    $stmt->bind_param("s", $customer_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($row = $result->fetch_assoc()) {
        // Verify password
        if ($customer_code == $row['customer_code']) {
            // Set session variables and redirect to a secure page
            if ($stmt = $conn->prepare("UPDATE keyboarder.customer SET customer_verification = ? WHERE customer_email = ?")) {
                $verified = 1;
                $stmt->bind_param("ss", $verified, $customer_email);
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) {
                    echo "Customer details updated successfully.";
                    header("Location: ../index.php");
                } else {
                    echo "No records updated";
                    display_errorMsg('Something went wrong, please try again later.');
                }

                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }

            header("Location: ../index.php");
            exit();
        } else {
            // Handle when password is incorrect
            display_errorMsg('Incorrect email or password');
        }
    } else {
        // Handle no user found
        echo $_SESSION['$customer_email'];
        echo $customer_code;
        echo "Error preparing statement: (" . $conn->errno . ") " . $conn->error;
        display_errorMsg('Incorrect token');
        exit();
    }
    // Close the statement
    $stmt->close();
}

// If there are errors, redirect back to registration
if (!empty($_SESSION['errorMsg'])) {
    header("Location: ../verify.php");
    exit();
}

// Close the connection
$conn->close();
?>