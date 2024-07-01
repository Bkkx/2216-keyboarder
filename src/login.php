<?php
session_start();
include "sessions/sessiontimeout.php";
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
                            <h2>New Keyboarder</h2>
                            <p>Start your DIY Journey with us!</p>
                            <a href="register.php" class="btn">Register</a>
                        </div>
                    </div>
                    <div class="right col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="login-form">
                            <h2>Login</h2>
                            <?php
                            if (isset($_SESSION['errorMsg'])) {
                                echo "<div id='loginMessage' class='errorMsg'>"; 
                                foreach ($_SESSION['errorMsg'] as $message) {
                                    echo "<p class='error'>" . htmlspecialchars($message) . "</p>";
                                }
                                echo "</div>";
                                unset($_SESSION['errorMsg']); // Clear the error message after displaying it
                            } else {
                                echo "<div id='loginMessage'></div>"; // Add this line to include the div for messages
                            }
                            ?>
                            <form id="loginForm" action="process/process_login.php" method="post">
                                <!-- Include the CSRF token in the form -->
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <p>
                                    <label for="customer_email">Email: <span>*</span></label>
                                    <input type="email" id="customer_email" name="customer_email" placeholder="Enter Email" required>
                                </p>
                                <p>
                                    <label for="customer_pwd">Password: <span>*</span></label>
                                    <input type="password" id="customer_pwd" name="customer_pwd" placeholder="Enter Password" required>
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
        <script defer src="js/login.js"></script>
    </body>
</html>