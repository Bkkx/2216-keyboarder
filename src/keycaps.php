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
                <img src="images/banner/keycap.jpg" class="category-banner" alt="Switches Category Banner">
            </div>
        <body>
        
        <h1 class="title">Keycaps</h1>

        <div class="container mt-5 selection">
            <div  id="keycapcard-deck" class="product-category row d-flex justify-content-center row-cols-3 g-3 mt-1">
                <!-- Content goes here -->
            </div>
        </div>

        <?php
        include "components/footer.inc.php";
        ?>
    </body>
    <script defer src="js/keycap.js"></script>
</html>

