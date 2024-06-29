<?php

session_start();

$success = true;
$_SESSION['verify_fail'];

// Include the configuration file
$config = require 'config.php';

// Create a new mysqli object with the configuration parameters
$conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
);
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    echo($errorMsg);
    $success = false;
} else {
    if ($success) {

        $_SESSION['verify_fail'] = 0; //reset the failed login attempts
        $product_name = $_POST['product_name'];
        $product_cost = $_POST['product_cost'];
        $category_id = $_POST['category_id'];
        $product_sd = $_POST['product_sd'];
        $product_ld = $_POST['product_ld'];
        $product_quantity = $_POST['product_quantity'];

        if ($category_id == 1) {
            $uploads_dir = '/images/switches/';
        }
        if ($category_id == 2) {
            $uploads_dir = '/images/cables/';
        }
        if ($category_id == 3) {
            $uploads_dir = '/images/keycaps/';
        }
        if ($category_id == 4) {
            $uploads_dir = '/images/keyboard/';
        }
        if ($category_id == 5) {
            $uploads_dir = '/images/barebone/';
        }

        $file = $_FILES['fileToUpload'];

        $name = $file['name'];
        $tmp_name = $file['tmp_name'];
        // Use $_SERVER['DOCUMENT_ROOT'] to get the document root directory
        $target_path = $_SERVER['DOCUMENT_ROOT'] . $uploads_dir . basename($name);

        if (move_uploaded_file($tmp_name, $target_path)) {
            echo "The file has been uploaded successfully!";
        } else {
            echo "There was an error uploading the file.";
        }

        // Prepare the statement
        $stmt = mysqli_prepare($conn, "INSERT INTO product "
                . "(product_name, product_cost, category_id, product_sd, product_ld, product_quantity) "
                . "VALUES (?, ?, ?, ?, ?, ?)");

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssisss", $product_name, $product_cost, $category_id, $product_sd, $product_ld, $product_quantity);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        $affected_rows = mysqli_stmt_affected_rows($stmt);
        if ($affected_rows > 0) {
            echo "<script>
            alert('Add successful. {$affected_rows} rows affected.');
            window.location.href = '../productlist.php';
            </script>";
        }
    } else {
        if ($_SESSION['verify_fail'] == 3) {
            //clean and destroy session
            $_SESSION = array();
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 42000, '/');
            }
            session_destroy();
           echo "<script>
            alert('Session closed! Reached Failed Attempts Limit! Please re-login.');
            window.location.href = '../index.php';
            </script>";
            $stmt->close();
            $conn->close();
        } else {
           echo "<script>
            alert('Add failed. No rows affected. $errorMsg');
            window.location.href = '../productlist.php';
            </script>";
        }
    }
    // Close the statement
    mysqli_stmt_close($stmt);
    // Close the database connection
    mysqli_close($conn);
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
