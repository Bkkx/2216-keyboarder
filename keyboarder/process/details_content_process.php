<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//table name
$table_name = $_GET['table'];
//columns name
$columns = $_GET['columns'];
//Product ID
$productid = $_GET['productid'];
// Include the configuration file
$config = require 'config.php';

// Create a new mysqli object with the configuration parameters
$conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
);

// Retrieve data from database based on table name and column names
$stmt = mysqli_prepare($conn, "SELECT $columns FROM $table_name INNER JOIN category ON $table_name.category_id = category.category_id WHERE $table_name.product_id = $productid ");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display data in Cards Item
while ($row = mysqli_fetch_assoc($result)) {
    $image_name = strtolower($row['category_name'] . '/' . str_replace(' ', '', $row[$table_name . '_name']));
    echo
    "<a class='back-button' href='".str_replace('_', ' ', $row['category_name']).".php'>Back To " . ucfirst(str_replace('_', ' ', $row['category_name'])) . " Page</a>".
    "<div id='product-details' class='details-container'>" .
    "<div class = 'card_container content row row-cols-3 g-3' data-category='" . str_replace('_', ' ', $row['category_name']) . "'>" .
    "<div class='col-lg-6 col-md-6 col-sm-12 col-12 mt-0 p-0'>" .
    "<div class='product-image'>" .
    "<img class='card-img-top' src='images/" . $image_name . ".jpg' alt='Card image cap' loading='lazy'>" .
    "</div>" .
    "</div>" .
    "<div class='col-lg-6 col-md-6 col-sm-12 col-12 mt-0 p-0'>" .
    "<div class='product-information'>" .
    "<h5 class='card-title'>" . $row[$table_name . '_name'] . "</h5>" .
    "<p class='card-text'>" . $row[$table_name . '_sd'] . "</p><br>" .
    "<strong>Item Description:</strong><br>" .
    "<p class='card-description'>" . $row[$table_name . '_ld'] . "</p>" .
    "<p class='card-price'><strong>SGD$" . limit_text($row[$table_name . '_cost'], 10) . "</strong></p>" .
    "<p class='card-text'>" .
    "<form action='process_addCart.php' method='post'>" .
    "<input type='hidden' id='productid' name='productid' value='$productid'>" .
    "<div class = 'counter'>" .
    "<span class = 'down' onClick ='decreaseCount(event, this)'>-</span>" .
    "<input name='num_item' id='num_item' type = 'number' value = '1'  maxlength='2' max='" . $row[$table_name . '_quantity'] . "'>" .
    "<span class = 'up' onClick = 'increaseCount(event, this)'>+</span>" .
    "</div >" .
    "<button class='addtocart mt-2' type='submit'>Add to Cart</button>" .
    "</form>" .
    "<p>Stock: " . $row[$table_name . '_quantity'] . "</p>" .
    "<p class='card-category'>Category: " . str_replace('_', ' ', $row['category_name']) . "</p>" .
    "</div>";
}

// Close prepared statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

function limit_text($text, $limit) {
    if (strlen($text) > $limit) {
        $text = substr($text, 0, $limit) . '...';
    }
    return $text;
}
?>

