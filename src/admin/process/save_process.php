<?php

session_start();

$success = true;
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
    if ($_GET['productid']) {
        if ($success) {
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_cost = $_POST['product_cost'];
            $category_id = $_POST['category_id'];
            $product_sd = $_POST['product_sd'];
            $product_ld = $_POST['product_ld'];
            $product_quantity = $_POST['product_quantity'];
            // Prepare the statement
            $stmt = mysqli_prepare($conn, "UPDATE keyboarder.product SET "
                    . "product_name = ?, "
                    . "product_cost = ?, "
                    . "category_id = ?, "
                    . "product_sd = ?, "
                    . "product_ld = ?, "
                    . "product_quantity = ? "
                    . "WHERE product_id = ?");

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssisssi", $product_name, $product_cost, $category_id, $product_sd, $product_ld, $product_quantity, $product_id);

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
            echo "<script>
            alert('Add failed. No rows affected. $errorMsg');
            window.location.href = '../productlist.php';
            </script>";
        }
        // Close the statement
        mysqli_stmt_close($stmt);
        // Close the database connection
        mysqli_close($conn);
    } else if ($_GET['customerid']) {
        if ($success) {
            $customer_id = $_POST['customer_id'];
            $customer_fname = $_POST['customer_fname'];
            $customer_lname = $_POST['customer_lname'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];
            $customer_number = $_POST['customer_number'];

            // Prepare the statement
            $stmt = mysqli_prepare($conn, "UPDATE customer SET "
                    . "customer_fname = ?, "
                    . "customer_lname = ?, "
                    . "customer_email = ?, "
                    . "customer_address = ?, "
                    . "customer_number = ? "
                    . "WHERE customer_id = ?");

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssssis", $customer_fname, $customer_lname, $customer_email, $customer_address, $customer_number, $customer_id);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);
            if ($affected_rows > 0) {
               echo "<script>
               alert('Add successful. {$affected_rows} rows affected.');
               window.location.href = '../userlist.php';
               </script>";
            }
        } else {
            echo "<script>
            alert('Add failed. No rows affected. $errorMsg');
            window.location.href = '../userlist.php';
            </script>";
        }
        // Close the statement
        mysqli_stmt_close($stmt);
        // Close the database connection
        mysqli_close($conn);
    } else if ($_GET['orderid']) {
        if ($success) {
            $order_id = $_POST['order_id'];
            $order_tracking_no = $_POST['order_tracking_no'];
            $order_status = $_POST['order_status'];

            // Prepare the statement
            $stmt = mysqli_prepare($conn, "UPDATE keyboarder.order SET "
                    . "order_tracking_no = ?, "
                    . "order_status = ? "
                    . "WHERE order_id = ?");

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssi", $order_tracking_no, $order_status, $order_id);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);
            if ($affected_rows > 0) {
               echo "<script>
               alert('Add successful. {$affected_rows} rows affected.');
               window.location.href = '../orderlist.php';
               </script>";
            }
        } else {
            echo "<script>
            alert('Add failed. No rows affected. $errorMsg');
            window.location.href = '../orderlist.php';
            </script>";
        }
    }
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
