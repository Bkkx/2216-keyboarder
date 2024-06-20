<?php

session_start();

//table name
$table_name = $_GET['table'];
//columns name
$columns = $_GET['columns'];
// Include the configuration file
$config = require 'config.php';
//Product ID
$specificid = $_GET['specificid'];
//Category
$cate = $_GET['cate'];

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
    if ($cate == "order") {
        $stmt = mysqli_prepare($conn, "SELECT $columns FROM keyboarder.$table_name WHERE $table_name" . "_id = $specificid");
    } else {
        $stmt = mysqli_prepare($conn, "SELECT $columns FROM $table_name WHERE $table_name" . "_id = $specificid");
    }
    // Execute the statement
    mysqli_stmt_execute($stmt);
    // Get the result set
    $result = mysqli_stmt_get_result($stmt);
    if ($cate == "customer") {
        echo '<h4>Editing Customer Details</h4>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form class='action-form' action='process/save_process.php?customerid=" . $row[$table_name . '_id'] . "' method='post'>" .
            "<input type='hidden' name='customer_id' value='" . $row[$table_name . '_id'] . "' required>" .
            "<div class='form-group'>" .
            "<label for='first_name'>First Name</label>" .
            "<input class='form-control' type='text' name='customer_fname' value='" . $row[$table_name . '_fname'] . "'>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='last_name'>Last Name</label>" .
            "<input class='form-control' type='text' name='customer_lname' value='" . $row[$table_name . '_lname'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='email'>Email</label>" .
            "<input class='form-control' type='email' name='customer_email' value='" . $row[$table_name . '_email'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='address'>Address</label>" .
            "<input class='form-control' type='text' name='customer_address' value='" . $row[$table_name . '_address'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='phone_number'>Phone Number</label>" .
            "<input class='form-control' type='number' name='customer_number' value='" . $row[$table_name . '_number'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='admin_pwd'>Enter Admin Password</label>" .
            "<input class='form-control password-text' type='password' name='admin_pwd' placeholder='Admin Password' required>" .
            "</div>" .
            "<input class='btn btn-success' type='submit' name='submit' value='Save'>" .
            "</form>";
        }
    }
    if ($cate == "product") {
        echo '<h4>Editing Product Details</h4>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form class='action-form' action='process/save_process.php?productid=" . $row[$table_name . '_id'] . "' method='post'>" .
            "<input type='hidden' name='product_id' value='" . $row[$table_name . '_id'] . "' required>" .
            "<div class='form-group'>" .
            "<label for='product_name'>Product Name</label>" .
            "<input class='form-control' type='text' name='product_name' value='" . $row[$table_name . '_name'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='product_cost'>Product Cost(SGD)</label>" .
            "<input class='form-control' type='text' name='product_cost' value='" . $row[$table_name . '_cost'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='product_cost'>Product Category<br>Barebone Kits: 5<br>Cables: 4<br>Keyboard: 3<br>keycaps: 2<br>Switches: 1</label>" .
            "<input class='form-control' type='number' name='category_id' value='" . $row['category_id'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='product_sd'>Product Short Description</label>" .
            "<input class='form-control' type='text' name='product_sd' value='" . $row[$table_name . '_sd'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='prodcut_ld'>Product Long Description</label>" .
            "<textarea class='form-control' name='product_ld' rows='5' required>" . $row[$table_name . '_ld'] . "</textarea>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='product_quantity'>Product Quantity</label>" .
            "<input class='form-control' type='number' name='product_quantity' value='" . $row[$table_name . '_quantity'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='admin_pwd'>Enter Admin Password</label>" .
            "<input class='form-control password-text' type='password' name='admin_pwd' placeholder='Admin Password' required>" .
            "</div>" .
            "<input class='btn btn-success' type='submit' name='submit' value='Save'>" .
            "</form>";
        }
    }
    if ($cate == "order") {
        echo '<h4>Editing Order Details</h4>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form class='action-form' action='process/save_process.php?orderid=" . $row[$table_name . '_id'] . "' method='post'>" .
            "<input type='hidden' name='order_id' value='" . $row[$table_name . '_id'] . "' required>" .
            "<div class='form-group'>" .
            "<label for='order_tracking_no'>Order Tracking No</label>" .
            "<input class='form-control' type='text' name='order_tracking_no' value='" . $row[$table_name . '_tracking_no'] . "' required>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='order_status'>Order Status</label>";
            if ($row[$table_name . '_status']) {
                echo "<p class='text-danger'>" . "Current Status: " . $row[$table_name . '_status'] . "</p>";
            } else {
                echo "<p class='text-danger'>" . "Current Status: None" . "</p>";
            }
            echo "<select class='form-control' name='order_status'>" .
            "<option value = 'Awaiting Fufillment'>Awaiting Fufillment</option>" .
            "<option value = 'Shipped'>Shipped</option>" .
            "<option value = 'Delivered'>Delivered</option > " .
            "</select>" .
            "</div>" .
            "<div class='form-group'>" .
            "<label for='admin_pwd'>Enter Admin Password</label>" .
            "<input class='form-control password-text' type='password' name='admin_pwd' placeholder='Admin Password' required>" .
            "</div>" .
            "<input class='btn btn-success' type='submit' name='submit' value='Save'>" .
            "</form>";
        }
    }
    // Close the statement
    mysqli_stmt_close($stmt);
    // Close the database connection
    mysqli_close($conn);
}    