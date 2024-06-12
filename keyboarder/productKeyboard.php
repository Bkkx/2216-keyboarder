<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "components/essential.inc.php"; ?>
        <link rel="stylesheet" href="css/main.css">
        <style>
            .card {
                margin-bottom: 20px; /* Add spacing between rows */
            }
             .category-banner-container {
                width: 100vw; /* Full viewport width */
                margin-bottom: 20px; /* Spacing below the banner */
                overflow: hidden; /* Prevent horizontal scroll */
            }
            .category-banner {
                width: 100%; /* Full width of container */
                height: auto; /* Maintain aspect ratio */
            }
            .card-link {
                text-decoration: none; /* Remove underline */
                color: #000000; /* Inherit text color */
            }
            .card-clickable {
            text-decoration: none; /* Remove underline */
            color: #000000; /* Set text color */
            }
            .card-clickable a {
            color: inherit; /* Inherit text color from parent */
            text-decoration: none;
            }
            .card-clickable:hover {
            text-decoration: none; /* Remove underline on hover */
            }
        </style>
    </head>
    <body>
        <?php include "components/nav.inc.php"; ?>

        <div class="category-banner-container">
                <img src="img/barebonekit.png" class="category-banner" alt="Switches Category Banner">
            </div>
        <main class="container">
           
            <div class="container mt-5 selection">
                <?php
                // Sample items array
                $items = [
                    ["name" => "Item 1", "price" => "$10.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                    ["name" => "Item 2", "price" => "$15.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                    ["name" => "Item 3", "price" => "$20.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                    ["name" => "Item 4", "price" => "$25.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                    ["name" => "Item 5", "price" => "$30.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                    ["name" => "Item 6", "price" => "$35.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                    ["name" => "Item 7", "price" => "$40.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                    ["name" => "Item 8", "price" => "$45.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                    ["name" => "Item 9", "price" => "$45.00", "image" => "img/switch.jpg", "desc" => "Lorum ipsum"],
                ];

                // Number of items per row
                $itemsPerRow = 4;
                $totalItems = count($items);
                
                 echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">';
        for ($i = 0; $i < $totalItems; $i++) {
            if ($i > 0 && $i % $itemsPerRow == 0) {
                echo '</div><div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">';
            }

            // Opening div for clickable card
            echo '<div class="col">';
            echo '<div class="card card-clickable">';
            echo '<a href="product.php">';
            // Card structure
            echo '
                <img src="' . $items[$i]["image"] . '" class="card-img-top" alt="' . $items[$i]["name"] . '">
                <div class="card-body">
                    <h5 class="card-title">' . $items[$i]["name"] . '</h5>
                    <h6 class="card-text">' . $items[$i]["desc"] . '</h6>
                    <p class="card-text">' . $items[$i]["price"] . '</p>
                </div>';
            // Closing anchor tag and div
            echo '</a>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>'; // Close the last row
        ?>
    </div>
        </main>
    </body>
</html>
