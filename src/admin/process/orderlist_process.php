<?php

//table name
$table_name = $_GET['table'];
//columns name
$columns = $_GET['columns'];
//page name
// Create database connection.
$config = require 'config.php';
// Create a new mysqli object with the configuration parameters
$conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
);

// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    echo($errorMsg);
    $success = false;
} else {
// Prepare the statement
    $stmt = mysqli_prepare($conn, "SELECT $columns FROM keyboarder.$table_name "
            . "INNER JOIN keyboarder.customer ON keyboarder.$table_name.customer_id = customer.customer_id "
            . "JOIN keyboarder.product on keyboarder.$table_name.product_id = product.product_id "
            . "ORDER BY $table_name" . "_id DESC");
    ;

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    echo "<tr>" .
    "<th>Order ID</th>" .
    "<th>Order Tracking No</th>" .
    "<th>Order Quantity</th>" .
    "<th>Order Status</th>" .
    "<th>Product ID</th>" .
    "<th>Product Name</th>" .
    "<th>Product Cost(SGD)</th>" .
    "<th>Customer ID</th>" .
    "<th>Customer Name</th>" .
    "<th>Customer Address</th>" .
    "<th>Actions</th>" .
    "</tr>";
    // Display data in Cards Item
    while ($row = mysqli_fetch_assoc($result)) {

        echo "<tr class ='itemcontent active'>" .
        "<td class='order_id'>OID" . $row['order_id'] . "</td>" .
        "<td class='order_tracking_no'>" . $row['order_tracking_no'] . "</td>" .
        "<td class='order_quantity'>" . $row['order_quantity'] . "</td>" .
        "<td class='order_status'>" . $row['order_status'] . "</td>" .
        "<td class='product_id'>PID" . $row['product_id'] . "</td>" .
        "<td class='product_name'>" . $row['product_name'] . "</td>" .
        "<td class='product_cost'>" . $row['product_cost'] . "</td>" .
        "<td class='customer_id'>CID" . $row['customer_id'] . "</td>" .
        "<td class='customer_name'>" . $row['customer_lname'] . "</td>" .
        "<td class='customer_address'>" . $row['customer_address'] . "</td>" .
        "<td>" .
        "<div class='action-container'>" .
        "<a href='edit.php?orderid=" . $row[$table_name . '_id'] . "'><button class='btn btn-warning edit-button'>Edit</button></a>" .
        "<form class='action-form' action='process/delete_process.php?orderid=" . $row[$table_name . '_id'] . "' method='post'>" .
        "<input type='hidden' name='order_id' value='" . $row[$table_name . '_id'] . "'>" .
        "<input class='password-text' type='password' name='admin_pwd' placeholder='Admin Password' required>" .
        "<input class='btn btn-danger' type='submit' name='submit' value='Delete'>" .
        "</form>" .
        "<div>" .
        "</td>" .
        "</tr>";
    }
    // Close the statement
    mysqli_stmt_close($stmt);
    // Close the database connection
    mysqli_close($conn);
}

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

?>
