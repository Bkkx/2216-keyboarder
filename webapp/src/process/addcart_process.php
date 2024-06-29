<?php
session_start();
addItemsCart();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function addItemsCart() {
    $quantity = $product = "";
    $whereisList = array();
    if ((!empty($_POST['num_item'])) && (!empty($_POST['productid']))) {
        $quantity = sanitize_input($_POST['num_item']);
        $product = sanitize_input($_POST['productid']);

        if (empty($_SESSION['cart'])) {
            $_SESSION['cart'][$product] = array(
                'qty' => $quantity
            );
        }
        $_SESSION['cart'][$product] = array(
            'qty' => $quantity
        );
        
        // Redirect to cart.php after adding the item to the cart
        header("Location: ../cart.php");
    }
}
?>