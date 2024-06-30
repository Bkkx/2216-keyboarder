<?php
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
    // die("Connection failed: " . $conn->connect_error);
    display_errorMsg("Unable to connect to the service, please try again later.");
    header("Location: ../profile.php");
    exit();
}

// Retrieve form data
$admin_id = $_SESSION['admin_id'];
$change_password = filter_input(INPUT_POST, 'change_password', FILTER_SANITIZE_STRING);
$admin_pwd = filter_input(INPUT_POST, 'admin_pwd', FILTER_SANITIZE_STRING);
$admin_confirm_pwd = filter_input(INPUT_POST, 'admin_confirm_pwd', FILTER_SANITIZE_STRING);


if ($change_password === "yes" && (empty($admin_pwd) || empty($admin_confirm_pwd))) {
    display_errorMsg("Password fields cannot be empty.");
}

// Validate password
if ($change_password === "yes" && strlen($admin_pwd) < 8) {
    display_errorMsg("Password must be at least 8 characters long.");
}

// Validate form data
if ($change_password === "yes" && ($admin_pwd !== $admin_confirm_pwd)) {
    display_errorMsg( "Passwords do not match.");
}

// If there are errors, redirect back to registration
if (!empty($_SESSION['errorMsg'])) {
    header("Location: ../profile.php");
    exit();
}

if ($change_password === "yes") {
    $hashed_password = password_hash($admin_pwd, PASSWORD_DEFAULT);
    $sql = "UPDATE keyboarder.admin SET admin_password = ? WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $admin_id);
    if ($stmt->execute()) {
        $_SESSION['successMsg'] = "Profile updated successfully.";
    } else {
        display_errorMsg("Error updating profile: " . $stmt->error);
    }
} else {
    $sql = "SELECT admin_email FROM keyboarder.admin WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    if ($stmt->execute()) {
        $stmt->bind_result($admin_email);
        $stmt->fetch();
        $_SESSION['successMsg'] = "Email fetched successfully.";
    } else {
        display_errorMsg("Error fetching email: " . $stmt->error);
    }
}


// Close the connection
$stmt->close();
$conn->close();

header("Location: ../profile.php");
?>