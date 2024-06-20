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
         <link rel="stylesheet" href="css/itemlist.css">
    </head>

    <body>
        <?php
        include "components/nav.inc.php";
        ?>
        <main class="container mt-5">
            <div class=" row row-cols-3 g-3">
                <div  class="col-lg-12 col-md-12 col-sm-12 col-12 table-responsive">
                    <table id="item-list" class="table">

                    </table>
                </div>
            </div>
        </main>
        <?php
        include "components/footer.inc.php";
        ?>
    </body>
     <script defer src="js/orderlist.js"></script>
</html>