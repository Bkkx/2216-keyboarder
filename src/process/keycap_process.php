<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
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
    if (limit_text($row['product_quantity'], 10) > 0 && $row['category_id']==3) {
        echo 
        "<div class = 'card_container content col-lg-3 col-md-6 col-sm-6 col-12 active'>" .
        "<a href='productdetails.php?id=" . $row['product_id'] . "'>" .
        "<div class='card h-100'>" .
        "<img class='card-img-top' src='images/keycaps/" . $row['product_name'] . ".jpg' alt='Card image cap' loading='lazy'>" .
        "<div class='card-body'>" .
        "<h5 class='card-title'>" . $row['product_name'] . "</h5>" .
        "<p class='card-text'>" . limit_text($row['product_sd'], 10) . "</p>" .
        "<p class='card-price'><strong>SGD$" . limit_text($row['product_cost'], 10) . "</strong></p>" .
        "<p class='card-text'>Stock: " . limit_text($row['product_quantity'], 10) . "</p>" .
        "</div>" .
        "</div>" .
        "</a>" .
        "</div>";
    }
    else if (limit_text($row['product_quantity'], 10) == 0 && $row['category_id']==3) 
    {
        echo 
        "<div class = 'card_container content col-lg-3 col-md-6 col-sm-6 col-12 active'>" .
        "<a href='productdetails.php?id=" . $row['product_id'] . "'>" .
        "<div class='card h-100'>" .
        "<img class='card-img-top' src='images/keycaps/" . $row['product_name'] . ".jpg' alt='Card image cap' loading='lazy'>" .
        "<div class='card-body'>" .
        "<h5 class='card-title'>" . $row['product_name'] . "</h5>" .
        "<p class='card-text'>" . limit_text($row['product_sd'], 10) . "</p>" .
        "<p class='card-price'><strong>SGD$" . limit_text($row['product_cost'], 10) . "</strong></p>" .
        "<h5 class='text-danger'>Out Of Stock</h5>" .
        "</div>" .
        "</div>" .
        "</a>" .
        "</div>";
        
    }
}

// Close prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
    ?>


