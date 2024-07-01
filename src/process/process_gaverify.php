<?php

// Start session
session_start();

// Include the config file
$config = include ('config.php');
require '../../vendor/autoload.php';
use PHPGangsta_GoogleAuthenticator;

// Create database connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

function display_errorMsg($message)
{
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
// if (strlen($customer_code) !== 6) {
//     display_errorMsg('Invalid token length.');
// }

$customer_email = $_SESSION['customer_email'];
// Validate CSRF token
// if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     display_errorMsg('CSRF token mismatch');
// }

// // Unset the CSRF token now that it's been checked
// unset($_SESSION['csrf_token']);

// Prepare SQL statement to avoid SQL injection
if ($stmt = $conn->prepare("SELECT customer_gacode FROM keyboarder.customer WHERE customer_email = ?")) {
    $stmt->bind_param("s", $customer_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($row = $result->fetch_assoc()) {

        $ga = new PHPGangsta_GoogleAuthenticator();
        $encryption_key = 'shouldbesecureenoughright?'; // Use the same key used for encryption
        $encrypted_secret = $row['customer_gacode'];
        $secret = openssl_decrypt($encrypted_secret, 'aes-256-cbc', $encryption_key, 0, '1234567890123456');
        $result = $ga->verifyCode($secret, $customer_code, 2); // 2 = 2*30sec clock tolerance

        // Verify password
        if ($result) {
            // Set session variables and redirect to a secure page
            $_SESSION['customer_email'] = $customer_email;
            $_SESSION['token'] = bin2hex(random_bytes(32)); // Generate a new token
            $_SESSION['token_time'] = time();
            $_SESSION['role'] = "customer";
            $_SESSION['customer_id'] = $row['customer_id'];
            header("Location: ../index.php");
            exit();
            } else {
                // echo "Error preparing statement: " . $conn->error;
                display_errorMsg('Please reenter the code!');
                header("Location: ../gaverify.php");
                exit();
            }
        } else {
            // Handle when password is incorrect
            display_errorMsg('Incorrect email or password');
        }
    } else {
        // Handle no user found
        // echo $_SESSION['$customer_email'];
        // echo $customer_code;
        // echo "Error preparing statement: (" . $conn->errno . ") " . $conn->error;
        display_errorMsg('Incorrect token');
        exit();
    }
    // Close the statement
    $stmt->close();


// If there are errors, redirect back to registration
if (!empty($_SESSION['errorMsg'])) {
    header("Location: ../gaverify.php");
    exit();
}

// Close the connection
$conn->close();
?>