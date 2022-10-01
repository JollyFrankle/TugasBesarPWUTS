<?php
session_start();

if($_SESSION["user"]["role"] ?? false == "admin"){
    header("Location: ./HomeAdmin.php");
} else if($_SESSION["user"]["role"] ?? false == "user"){
    header("Location: ./HomeUser.php");
} else {
    header("Location: ./LoginPage.php");
}
?>