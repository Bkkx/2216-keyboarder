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
    //check if there extra purpose

    
        // Prepare the statement
        $stmt = mysqli_prepare($conn, "SELECT $columns FROM $table_name ORDER BY $table_name" . "_id DESC");

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result set
        $result = mysqli_stmt_get_result($stmt);
        echo "<tr>" .
        "<th>Customer ID</th>" .
        "<th>First Name</th>" .
        "<th>Last Name</th>" .
        "<th>Email</th>" .
        "<th>Address</th>" .
        "<th>Number</th>" .
        "<th>Points</th>" .
        "<th>Join Date</th>" .
        "<th>Actions</th>" .
        "</tr>";
        // Display data in Cards Item
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class ='itemcontent active'>" .
            "<td class='customer_id'>CID" . $row['customer_id'] . "</td>" .
            "<td class='customer_fname'>" . $row['customer_fname'] . "</td>" .
            "<td class='customer_lname'>" . $row['customer_lname'] . "</td>" .
            "<td class='customer_email'>" . $row['customer_email'] . "</td>" .
            "<td class='customer_address'>" . $row['customer_address'] . "</td>" .
            "<td class='customer_number'>" . $row['customer_number'] . "</td>" .
            "<td>" . $row['customer_points'] . "</td>" .
            "<td>" . $row['customer_joindate'] . "</td>" .
            "<td>" .
            "<div class='action-container'>" .
            "<a href='edit.php?customerid=" . $row['customer_id'] . "'><button class='btn btn-warning edit-button'>Edit</button></a>" .
            "<form class='action-form' action='process/delete_process.php?customerid=" . $row['customer_id'] . "' method='post'>" .
            "<input type='hidden' name='customer_id' value='" . $row['customer_id'] . "'>" .
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
