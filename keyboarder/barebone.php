<?php
session_start();
include "sessions/sessiontimeout.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "components/essential.inc.php"; ?>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/catalog.css">
    </head>
    <body>
        <?php include "components/nav.inc.php"; ?>

        <div class="category-banner-container">
                <img src="images/banner/barebone.jpg" class="category-banner" alt="Switches Category Banner">
            </div>
        <body>
        
        <h1 class="title">Barebone</h1>

        <div class="container mb-5 selection">
            <div  id="barebonecard-deck" class="product-category row d-flex justify-content-center row-cols-3 g-3 mt-1">
                <!-- Content goes here -->
            </div>
        </div>

        <?php
        include "components/footer.inc.php";
        ?>
    </body>
    <script defer src="js/barebone.js"></script>
</html>
