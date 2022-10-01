<?php
$host = "localhost";
$user = "user_pw";
$pass = "BerlariDanTenggelam";
$name = "tubes_pw_uts";
$conn = mysqli_connect($host, $user, $pass, $name);
if (mysqli_connect_errno()) {
    echo "Failed to connect : " . mysqli_connect_error();
}
error_reporting(E_ALL);

// log errors to file
// ini_set("log_errors", 1);
// ini_set("error_log", __DIR__ . "/php-error.log");
?>