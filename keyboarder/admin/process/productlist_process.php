<?php

session_start();

//table name
$table_name = $_GET['table'];
//columns name
$columns = $_GET['columns'];
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
    // Prepare the statement
    $stmt = mysqli_prepare($conn, "SELECT $columns FROM $table_name "
            . "INNER JOIN category ON $table_name.category_id = category.category_id "
            . "ORDER BY $table_name" . "_id DESC ");

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);
    echo "<tr>" .
    "<th>Product ID</th>" .
    "<th>Product Name</th>" .
    "<th>Product Cost(SGD)</th>" .
    "<th>Category</th>" .
    "<th>Short Descripion</th>" .
    "<th>Long Description</th>" .
    "<th>Quantity</th>" .
    "<th>Actions</th>" .
    "</tr>";
    // Display data in Cards Item
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class ='itemcontent active'>" .
        "<td class='product_id'>PID" . $row[$table_name . '_id'] . "</td>" .
        "<td class='product_name'>" . $row[$table_name . '_name'] . "</td>" .
        "<td class='product_cost'>" . $row[$table_name . '_cost'] . "</td>" .
        "<td class='product_sd'>" . str_replace('_', ' ', $row['category_name']) . "</td>" .
        "<td class='product_ld'>" . $row[$table_name . '_sd'] . "</td>" .
        "<td class='product_quantity'>" . $row[$table_name . '_ld'] . "</td>" .
        "<td>" . $row[$table_name . '_quantity'] . "</td>" .
        "<td>" .
        "<div class='action-container'>" .
        "<a href='edit.php?productid=" . $row[$table_name . '_id'] . "'><button class='btn btn-warning edit-button'>Edit</button></a>" .
        "<form class='action-form' action='process/delete_process.php?productid=" . $row[$table_name . '_id'] . "' method='post'>" .
        "<input type='hidden' name='product_id' value='" . $row[$table_name . '_id'] . "'>" .
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