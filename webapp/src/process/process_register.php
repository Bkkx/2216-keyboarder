<?php
// Start session
session_start();

// Include the config file
$config = include('config.php');

// Create database connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

$secret = '6LePCAIqAAAAAFtwaYjIcjOvd-3YND2giUFR0qJW';  // Replace with your secret key
$response = $_POST['recaptcha_response'];
$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
$responseData = json_decode($verify);

function display_errorMsg($message) {
    if (!isset($_SESSION['errorMsg'])) {
        $_SESSION['errorMsg'] = [];
    }
    $_SESSION['errorMsg'][] = $message;

}

// Check connection
if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
    display_errorMsg("Unable to connect to the service, please try again later.");
    header("Location: ../register.php");
    exit();
}


// Retrieve and sanitize form data
$customer_fname = filter_input(INPUT_POST, 'customer_fname', FILTER_SANITIZE_STRING);
$customer_lname = filter_input(INPUT_POST, 'customer_lname', FILTER_SANITIZE_STRING);
$customer_email = filter_input(INPUT_POST, 'customer_email', FILTER_SANITIZE_EMAIL);
$customer_address = filter_input(INPUT_POST, 'customer_address', FILTER_SANITIZE_STRING);
$customer_number = filter_input(INPUT_POST, 'customer_number', FILTER_SANITIZE_STRING);
$customer_pwd = filter_input(INPUT_POST, 'customer_pwd', FILTER_SANITIZE_STRING);
$confirm_pwd = filter_input(INPUT_POST, 'confirm_pwd', FILTER_SANITIZE_STRING);
$customer_points = filter_input(INPUT_POST, 'customer_points', FILTER_SANITIZE_NUMBER_INT);
$customer_join_date = filter_input(INPUT_POST, 'customer_join_date', FILTER_SANITIZE_STRING);

// Regex Patterns
$pattern_name = "/^[a-zA-Z\s'-]+$/";;
$pattern_address = "/^[a-zA-Z0-9\s,.'-]+$/";
$pattern_number = "/^\d{8}$/";

// Validate First Name
if (!preg_match($pattern_name, $customer_fname)) {
    // Handle invalid input
    display_errorMsg("First name contains invalid characters.");
}

// Validate Last Name
if (!preg_match($pattern_name, $customer_lname)) {
    // Handle invalid input
    display_errorMsg("Last name contains invalid characters.");
}

// Validate Email
if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
    display_errorMsg("Invalid email format.");
}

// Validate Address
if (!preg_match($pattern_address, $customer_address)) {
    display_errorMsg("Address contains invalid characters.");
}

// Validate Phone Number
if (!preg_match($pattern_number, $customer_number)) {
    display_errorMsg("Phone number must be exactly 8 digits.");
}

// Validate password
if (strlen($customer_pwd) < 8) {
    display_errorMsg("Password must be at least 8 characters long.");
}

// Check if passwords match
if ($customer_pwd !== $confirm_pwd) {
    display_errorMsg("Passwords do not match.");
}

// Check for existing email
if (empty($_SESSION['errorMsg'])) {
    $stmt = $conn->prepare("SELECT * FROM keyboarder.customer WHERE customer_email = ?");
    $stmt->bind_param("s", $customer_email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        display_errorMsg("Email is already in use.");
    }
    $stmt->close();
}

// Validation of CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    display_errorMsg('CSRF token mismatch');
}

// Unset CSRF token after checking it
unset($_SESSION['csrf_token']);

if ($responseData->success && $responseData->score < 0.5) {  // Choose your threshold
    display_errorMsg('reCAPTCHA verification failed. Are you a robot?');
}

// Proceed with registration if no errors
if (empty($_SESSION['errorMsg'])) {
    $hashed_pwd = password_hash($customer_pwd, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO keyboarder.customer (customer_fname, customer_lname, customer_email, customer_address, customer_number, customer_password, customer_points, customer_joindate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisss", $customer_fname, $customer_lname, $customer_email, $customer_address, $customer_number, $hashed_pwd, $customer_points, $customer_join_date);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Registration successful. You can now log in.";
        header("Location: ../login.php");
        exit();
    } else {
        display_errorMsg("Registration failed, please try again later.");
    }
    $stmt->close();
}

// If there are errors, redirect back to registration
if (!empty($_SESSION['errorMsg'])) {
    header("Location: ../register.php");
    exit();
}

// Close the connection
$conn->close();
?>