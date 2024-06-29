<?php
session_start();
include "components/essential.inc.php";
include "components/nav.inc.php";

// Include the config file
$config = include('process/config.php');

// Create database connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch customer data using customer_id from session
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM keyboarder.customer WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Fetch orders for the customer
$order_sql = "SELECT * FROM `order` WHERE customer_id = ?";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $customer_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$orders = $order_result->fetch_all(MYSQLI_ASSOC);
?>

<html lang="en">
    <head>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/profile.css">
        <style>
            .form-group {
                margin-bottom: 20px;
            }
            #passwordFields {
                display: none;
            }
            .orders-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            .orders-table th, .orders-table td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            .orders-table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #102C57;
                color: white;
            }
        </style>
        <script>
            function togglePasswordFields() {
                var passwordFields = document.getElementById("passwordFields");
                if (document.getElementById("change_password").value === "yes") {
                    passwordFields.style.display = "block";
                } else {
                    passwordFields.style.display = "none";
                }
            }
        </script>
    </head>
    <body>
        <main class="container mt-5">
            <div class="profile-container">
                <div class="profile-header">
                    <h2>Your Profile</h2>
                </div>
                <div class="profile-form">
                    <form action="process/process_profile.php" method="post">
                        <div class="form-group">
                            <label for="customer_fname">First Name:</label>
                            <input type="text" id="customer_fname" name="customer_fname" value="<?php echo $customer['customer_fname']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_lname">Last Name:</label>
                            <input type="text" id="customer_lname" name="customer_lname" value="<?php echo $customer['customer_lname']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_email">Email:</label>
                            <input type="email" id="customer_email" name="customer_email" value="<?php echo $customer['customer_email']; ?>" required readonly>
                        </div>

                        <div class="form-group">
                            <label for="customer_address">Address:</label>
                            <input type="text" id="customer_address" name="customer_address" value="<?php echo $customer['customer_address']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="customer_number">Phone Number:</label>
                            <input type="tel" id="customer_number" name="customer_number" value="<?php echo $customer['customer_number']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="change_password">Change Password:</label>
                            <select id="change_password" name="change_password" onchange="togglePasswordFields()">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>

                        <div id="passwordFields" class="form-group">
                            <label for="customer_pwd">New Password:</label>
                            <input type="password" id="customer_pwd" name="customer_pwd" placeholder="Enter new password">
                            <label for="confirm_pwd">Confirm New Password:</label>
                            <input type="password" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm new password">
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Update Profile">
                        </div>
                    </form>
                </div>

                <div class="orders-container">
                    <h2>Your Orders</h2>
                    <?php if (count($orders) > 0): ?>
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product ID</th>
                                    <th>Quantity</th>
                                    <th>Tracking No.</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo $order['order_id']; ?></td>
                                        <td><?php echo $order['product_id']; ?></td>
                                        <td><?php echo $order['order_quantity']; ?></td>
                                        <td><?php echo $order['order_tracking_no']; ?></td>
                                        <td><?php echo $order['order_status']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No orders found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
        <?php include "components/footer.inc.php"; ?>
    </body>
</html>

<?php
$stmt->close();
$conn->close();
$order_stmt->close();
?>