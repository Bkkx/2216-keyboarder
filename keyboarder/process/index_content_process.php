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

// Prepare the statement
$stmt = mysqli_prepare($conn, "SELECT $columns FROM $table_name");

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

// Display data in Cards Item
while ($row = mysqli_fetch_assoc($result)) {

    $image_name = strtolower($row['category_name'] . '/' . "home_card");
    echo "<div class = 'card_container col-lg-2 col-md-6 col-sm-6 col-12'>" .
    "<a href='" . strtolower($row[$table_name . '_name']) .'.php' . "'>" .
    "<div class='card h-100'>" .
    "<img class='card-img-top' src='images/" . $image_name . ".jpg' alt='Card image cap' loading='lazy'>" .
    "<div class='card-body'>" .
    "<h5 class='card-title text-center'>" . ucfirst(str_replace('_', ' ', $row[$table_name . '_name'])) . "</h5>" .
    "</div>" .
    "</div>" .
    "</a>" .
    "</div>";
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);
?>

