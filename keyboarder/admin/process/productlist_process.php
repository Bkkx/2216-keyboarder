<?php

session_start();

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
