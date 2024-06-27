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
        <link rel="stylesheet" href="css/login_reg.css">
    </head>

    <body>
        <?php
        include "components/nav.inc.php";
        ?>
        <main class="container mt-5">
            <div class="login">
                <div class="logincontainer row-cols-3 g-3">
                    <div class="left col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="login-text">
                            <h2>New Keyboarder??</h2>
                            <p>Start your DIY Journey with us!</p>
                            <a href="register.php" class="btn">Register</a>
                        </div>
                    </div>
                    <div class="right col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="login-form">
                            <h2>Login</h2>
                            <form action="process/process_login.php" method="post">
                                <p>
                                    <label for="customer_email">Email: <span>*</span></label>
                                    <input type="text" id="customer_email" name="customer_email" placeholder="Enter Email" required>
                                </p>
                                <p>
                                    <label for="customer_pwd">Password: <span>*</span></label>
                                    <input type="text" id="customer_pwd" name="customer_pwd" placeholder="Enter Password" required>
                                </p>
                                <div id="html_element"></div>
                                <p>
                                    <input type="submit" value="Sign In">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include "components/footer.inc.php";
        ?>
    </body>
</html>