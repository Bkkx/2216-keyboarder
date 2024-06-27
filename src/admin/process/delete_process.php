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
    if ($_GET['customerid']) {
        if ($success) {
            $_SESSION['verify_fail'] = 0; //reset the failed login attempts
            $customer_id = $_POST['customer_id'];
            // Prepare the statement
            $stmt = mysqli_prepare($conn, "DELETE FROM customer WHERE customer_id= $customer_id");

            // Execute the statement
            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);
            if ($affected_rows > 0) {
                echo "<script>
                alert('Delete successful. {$affected_rows} rows affected.');
                window.location.href = '../userlist.php';
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
                echo "<script>alert('Session closed! Reached Failed Attempts Limit! Please re-login.')</script>";
                echo "<script type='text/javascript'>location.href='../index.php'</script>";
                $stmt->close();
                $conn->close();
            } else {
                echo "<script>
                alert('Delete failed. No rows affected. $errorMsg');
                window.location.href = '../userlist.php';
                </script>";
            }
        }
        // Close the statement
        mysqli_stmt_close($stmt);
        // Close the database connection
        mysqli_close($conn);
    }
    if ($_GET['productid']) {
        if ($success) {
            $_SESSION['verify_fail'] = 0; //reset the failed login attempts
            $product_id = $_POST['product_id'];
            // Prepare the statement
            $stmt = mysqli_prepare($conn, "DELETE FROM product WHERE product_id= $product_id");

            // Execute the statement
            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);
            if ($affected_rows > 0) {
                echo "<script>
                alert('Delete successful. {$affected_rows} rows affected.');
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
                echo "<script>alert('Session closed! Reached Failed Attempts Limit! Please re-login.')</script>";
                echo "<script type='text/javascript'>location.href='index.php'</script>";
                $stmt->close();
                $conn->close();
            } else {
                echo "<script>
                alert('Delete failed. No rows affected. $errorMsg');
                window.location.href = '../productlist.php';
                </script>";
            }
        }
        // Close the statement
        mysqli_stmt_close($stmt);
        // Close the database connection
        mysqli_close($conn);
    }
    if ($_GET['orderid']) {
        if ($success) {
            $_SESSION['verify_fail'] = 0; //reset the failed login attempts
            $customer_id = $_POST['order_id'];
            // Prepare the statement
            $stmt = mysqli_prepare($conn, "DELETE FROM order WHERE order_id= $order_id");

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
            if ($_SESSION['verify_fail'] == 3) {
                //clean and destroy session
                $_SESSION = array();
                if (isset($_COOKIE[session_name()])) {
                    setcookie(session_name(), '', time() - 42000, '/');
                }
                session_destroy();
                echo "<script>alert('Session closed! Reached Failed Attempts Limit! Please re-login.')</script>";
                echo "<script type='text/javascript'>location.href='index.php'</script>";
                $stmt->close();
                $conn->close();
            } else {
                echo "<script>
                alert('Delete failed. No rows affected. $errorMsg');
                window.location.href = '../orderlist.php';
                </script>";
            }
        }
        // Close the statement
        mysqli_stmt_close($stmt);
        // Close the database connection
        mysqli_close($conn);
    }
}

