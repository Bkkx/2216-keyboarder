<?php
session_start();
include "sessions/sessiontimeout.php";

$_SESSION['token'] = $token;
$_SESSION['token_time'] = time();
$_SESSION['role'] = "admin"; //setting role of user session to customer. to verify is logged in and is user to make some website unaccessible
$_SESSION['admin_id'] = 1;
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
        <main class="container">
            <h1 class="display-4">User List</h1>
            <div class="filter_panel">
            </div>
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
    <script defer src="js/userlist.js"></script>
</html>