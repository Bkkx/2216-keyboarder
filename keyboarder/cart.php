<?php
session_start();
include "sessions/sessiontimeout.php";
?>
<html lang="en">
    <head>
        <?php
        include "components/essential.inc.php";
        ?>

        <link rel="stylesheet" href="css/main.css">
    </head>

    <body>
        <?php
        include "components/nav.inc.php";
        ?>
        <main class="container mt-5">
            <h1> Shopping Cart</h1>
            <form action="process_checkoutCart.php" method="post">
                <div class="cart-list" id="cart-list">
                </div>
                <?php
                if (empty($_SESSION['cart'])) {
                    echo "<h2>Cart is empty!<h2>";
                } else {
                    echo "<p class=mt-3>" .
                    "<input class='purchase-button addtocart' type='submit' value='Purchase'>" .
                    "</p>";
                }
                ?>
                </p>
            </form>      
        </main>
        <?php
        include "components/footer.inc.php";
        ?>
    </body>
       <link rel="stylesheet" href="css/productdetails.css">
    <script defer src="js/cart.js"></script>
</html>