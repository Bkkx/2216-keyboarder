<?php
// Start session
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';


// Include the config file
$config = include ('config.php');

// Create database connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

$secret = '6LePCAIqAAAAAFtwaYjIcjOvd-3YND2giUFR0qJW';  // Replace with your secret key
$response = $_POST['recaptcha_response'];
$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
$responseData = json_decode($verify);

function display_errorMsg($message)
{
    if (!isset($_SESSION['errorMsg'])) {
        $_SESSION['errorMsg'] = [];
    }
    $_SESSION['errorMsg'][] = $message;

}

// Check connection
if ($conn->connect_error) {
    display_errorMsg("Unable to connect to the service, please try again later.");
}

function generateVerificationCode($length = 6)
{
    if ($length <= 0) {
        throw new InvalidArgumentException('Length must be a positive integer.');
    }
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $code;
}

function sendVerificationEmail($verificationCode, $customer_email, $customer_fname)
{
    $mail = new PHPMailer(true);
    try {

        $mail->IsSMTP();

        //        $mail->SMTPDebug = 2;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "keyboarderweb@gmail.com";
        $mail->Password = "pjccovdqzecxrhxl";

        $mail->IsHTML(true);
        $mail->AddAddress($customer_email);
        $mail->SetFrom("keyboarderweb@gmail.com");
        $mail->Subject = 'Get Verifiedat Keyboarder!';
        $mail->Body = "Dear $customer_fname,\n

            Welcome to KeyBoarder!\n\n

            Thank you for joining us. We are excited to have you as a part of our community.\n

            To complete your registration, please use the verification code below:\n

            Verification Code: $verificationCode\n

            If you did not sign up for this account, please ignore this email.\n\n

            Best regards,\n
            The KeyBoarder Team
            ";



        $mail->send();
        // header("location: contact.php#form-details");
        echo "done bish";
    } catch (Exception $e) {
        // header("location: contact.php#form-details");
        display_errorMsg($e->getMessage());
    }
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
$pattern_name = "/^[a-zA-Z\s'-]+$/";
;
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

    $code = generateVerificationCode(6);
    sendVerificationEmail($code,$customer_email, $customer_fname);
    $validated = 0;
    $stmt = $conn->prepare("INSERT INTO keyboarder.customer (customer_fname, customer_lname, customer_email, customer_address, customer_number, customer_password, customer_points, customer_joindate, customer_verification, customer_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisssis", $customer_fname, $customer_lname, $customer_email, $customer_address, $customer_number, $hashed_pwd, $customer_points, $customer_join_date, $validated, $code);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Registration successful. You can now log in.";
        $_SESSION['customer_email'] = $customer_email;
        header("Location: ../verify.php"); 
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