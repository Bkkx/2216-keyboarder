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

// Graceful handling of connection error
if ($conn->connect_error) {
    $_SESSION['errorMsg'] = "Connection failed: " . $conn->connect_error;
    header("Location: ../index.php");
    exit();
}

// Prepare the statement with safe variables
$query = "SELECT $columns FROM $table_name";
if ($stmt = $conn->prepare($query)) {
    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Display data in Cards Item
    while ($row = $result->fetch_assoc()) {
        $image_name = htmlspecialchars(strtolower($row['category_name'] . '/' . "home_card"));
        echo "<div class='card_container col-lg-2 col-md-6 col-sm-6 col-12'>" .
        "<a href='" . htmlspecialchars(strtolower($row[$table_name . '_name'])) .'.php' . "'>" .
        "<div class='card h-100'>" .
        "<img class='card-img-top' src='images/" . htmlspecialchars($image_name) . ".jpg' alt='Card image cap' loading='lazy'>" .
        "<div class='card-body'>" .
        "<h5 class='card-title text-center'>" . htmlspecialchars(ucfirst(str_replace('_', ' ', $row[$table_name . '_name']))) . "</h5>" .
        "</div>" .
        "</div>" .
        "</a>" .
        "</div>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
mysqli_close($conn);
?>

