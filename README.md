# 2216-keyboarder
## Prerequisites
1. Setup PHP Environment - VS16 x64 Thread Safe <br />
Link: https://windows.php.net/download#php-8.3 <br />
How to: https://www.geeksforgeeks.org/how-to-install-php-in-windows-10/<br />

2. Netbeans to Run the project

## Database (Local)
### Setup
MySQL Sever:<br />
https://dev.mysql.com/downloads/mysql/ <br />

Use my sql workbench to connect and create database keyboarder(utf-8) <br />
load ```keyboarder_schema.sql ``` <br />
Add ```use keyboarder``` at 1st line of the SQL.

### Connection
Edit the Config file to match your Local Credential <br /> 
Under ``` process/config.php ```

<?php
// config.php
return [
    'servername' => 'localhost',  // or your server name
    'username' => 'root',
    'password' => 'your_password',
    'dbname' => 'keyboarder'
];
?>
