<?php

// Start session
session_start();

// Include the config file
$config = include ('config.php');

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
$qrcode = filter_input(INPUT_POST, 'qr_code', FILTER_SANITIZE_STRING);

// Validate Email
// if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
//     display_errorMsg('Invalid email format.');
// }

// Validate password
if ($qrcode !== '1') {
    display_errorMsg('Error, please try again.');
}

// Validate CSRF token
if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    display_errorMsg('CSRF token mismatch');
}


// Unset the CSRF token now that it's been checked
unset($_SESSION['csrf_token']);



if (empty($_SESSION['errorMsg'])) {
    $validated = 0;
    $customer_email = $_SESSION['customer_email'];
    $customer_gacode = $_SESSION['GA_secret'];

    if ($stmt = $conn->prepare("UPDATE keyboarder.customer SET customer_gacode = ? WHERE customer_email = ?")) {
        $verified = 1;
        $stmt->bind_param("ss", $customer_gacode, $customer_email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            display_errorMsg("Thank you for registering! Please log in to proceed.");
            header("Location: ../login.php");
        } else {
            echo "No records updated";
            display_errorMsg('Something went wrong, please try again later.');
        }
        unset($_SESSION['customer_email']);
        unset($_SESSION['GA_secret']);


        $stmt->close();
        $conn->close();

    }
} else {
    header("Location: ../qrcode.php");
    exit();
}




// Prepare SQL statement to avoid SQL injection

// Close the connection
?>