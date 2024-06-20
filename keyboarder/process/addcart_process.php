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
    }
}
?>

<html>
    <head>
        <?php
        include "components/essential.inc.php";
        ?>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/productdetails.css">
    </head>
    <body>
        <?php
        include "components/nav.inc.php";
        ?>

        <header class="jumbotron text-center">
            <h3 class="display-4">Product Details</h3>
        </header>
        <main class="container">
            <div id="product-details">
                <h2 style="margin-bottom: 30px;">Items been added to cart!</h2>
                <?php
                foreach ($_SESSION['cart'] as $key => $value) {
                    echo "Key: " . $key . ", Quantity: " . $value['qty'] . "<br>";
                }
                ?>
            </div>
            <a class="back-button" href="../cart.php">Back To Product Page</a>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>