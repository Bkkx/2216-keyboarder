<?php
session_start();

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

if ($conn->connect_error) {
    $_SESSION['errorMsg'] = "Connection failed: " . $conn->connect_error;
    header("Location: ../productdetails.php");
    exit();
}


// Prepare the SQL statement to prevent SQL injection
$query = sprintf("SELECT %s FROM %s INNER JOIN category ON %s.category_id = category.category_id WHERE %s.product_id = ?", 
    $conn->real_escape_string($columns), 
    $conn->real_escape_string($table_name),
    $conn->real_escape_string($table_name),
    $conn->real_escape_string($table_name)
);

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $productid);
$stmt->execute();
$result = $stmt->get_result();


// Display data in Cards Item
while ($row = $result->fetch_assoc()) {
    $image_name = strtolower($row['category_name'] . '/' . htmlspecialchars(str_replace(' ', '', $row[$table_name . '_name'])));
    echo
    "<a class='back-button' href='" . htmlspecialchars(str_replace('_', ' ', $row['category_name'])).".php'>Back To " . htmlspecialchars(ucfirst(str_replace('_', ' ', $row['category_name']))) . " Page</a>".
    "<div id='product-details' class='details-container'>" .
    "<div class = 'card_container content row row-cols-3 g-3' data-category='" . htmlspecialchars(str_replace('_', ' ', $row['category_name'])) . "'>" .
    "<div class='col-lg-6 col-md-6 col-sm-12 col-12 mt-0 p-0'>" .
    "<div class='product-image'>" .
    "<img class='card-img-top' src='images/" . htmlspecialchars($image_name) . ".jpg' alt='Card image cap' loading='lazy'>" .
    "</div>" .
    "</div>" .
    "<div class='col-lg-6 col-md-6 col-sm-12 col-12 mt-0 p-0'>" .
    "<div class='product-information'>" .
    "<h5 class='card-title'>" . htmlspecialchars($row[$table_name . '_name']) . "</h5>" .
    "<p class='card-text'>" . htmlspecialchars($row[$table_name . '_sd']) . "</p><br>" .
    "<strong>Item Description:</strong><br>" .
    "<p class='card-description'>" . htmlspecialchars($row[$table_name . '_ld']) . "</p>" .
    "<p class='card-price'><strong>SGD$" . htmlspecialchars(limit_text($row[$table_name . '_cost'], 10)) . "</strong></p>" .
    "<p class='card-text'>" .
    "<form action='process/addcart_process.php' method='post'>" .
    "<input type='hidden' id='productid' name='productid' value='$productid'>" .
    "<input type='hidden' id='stock' name='stock' value=" . htmlspecialchars($row[$table_name . '_quantity']) . "'>" .
    "<div class = 'counter'>" .
    "<span class = 'down' onClick ='decreaseCount(event, this)'>-</span>" .
    "<input name='num_item' id='num_item' type = 'number' value = '1'  maxlength='2' max='" . htmlspecialchars($row[$table_name . '_quantity']) . "' min='1'>" .
    "<span class = 'up' onClick = 'increaseCount(event, this)'>+</span>" .
    "</div >" .
    "<button class='addtocart mt-2' type='submit'>Add to Cart</button>" .
    "</form>" .
    "<p>Stock: " . htmlspecialchars($row[$table_name . '_quantity']) . "</p>" .
    "<p class='card-category'>Category: " . htmlspecialchars(str_replace('_', ' ', $row['category_name'])) . "</p>" .
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

