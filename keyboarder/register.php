<html lang="en">
    <head>
        <?php
        include "components/essential.inc.php";
        session_start();
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
                            <h2>Welcome!</h2>
                            <p>Join our community and start your journey with us!</p>
                            <a href="login.php" class="btn">Login</a>
                        </div>
                    </div>
                    <div class="right col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="login-form">
                            <h2>Register</h2>
                            <form action="process_register.php" method="post">
                                <p>
                                    <label for="customer_fname">First Name: <span>*</span></label>
                                    <input type="text" id="customer_fname" name="customer_fname" placeholder="Enter First Name" required>
                                </p>
                                <p>
                                    <label for="customer_lname">Last Name: <span>*</span></label>
                                    <input type="text" id="customer_lname" name="customer_lname" placeholder="Enter Last Name" required>
                                </p>
                                <p>
                                    <label for="customer_email">Email: <span>*</span></label>
                                    <input type="email" id="customer_email" name="customer_email" placeholder="Enter Email" required>
                                </p>
                                <p>
                                    <label for="customer_address">Address: <span>*</span></label>
                                    <input type="text" id="customer_address" name="customer_address" placeholder="Enter Address" required>
                                </p>
                                <p>
                                    <label for="customer_number">Phone Number: <span>*</span></label>
                                    <input type="tel" id="customer_number" name="customer_number" placeholder="Enter Phone Number" required>
                                </p>
                                <p>
                                    <label for="customer_pwd">Password: <span>*</span></label>
                                    <input type="password" id="customer_pwd" name="customer_pwd" placeholder="Enter Password" required>
                                </p>
                                <p>
                                    <label for="confirm_pwd">Confirm Password: <span>*</span></label>
                                    <input type="password" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password" required>
                                </p>
                                <!-- Hidden fields for points and join date -->
                                <input type="hidden" name="customer_points" value="0">
                                <input type="hidden" name="customer_join_date" value="<?php echo date('Y-m-d'); ?>">
                                <p>
                                    <input type="submit" value="Register">
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