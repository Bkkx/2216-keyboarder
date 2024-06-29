<?php session_start();

$inactive = 1800;
if (isset($_SESSION["token_time"])) {
    $sessionTTL = time() - $_SESSION["token_time"];
    if ($sessionTTL > $inactive) {
    session_destroy();
    header("Location: login.php");
    }
}
$_SESSION['token_time'] = time();

?>