<?php
session_start();

if(!isset($_SESSION["user"]["role"])) {
    header("Location: ./LoginPage.php");
}
if(($_SESSION["user"]["role"] ?? "") === "admin"){
    header("Location: ./HomeAdmin.php");
} else if(($_SESSION["user"]["role"] ?? "") === "user"){
    header("Location: ./HomeUser.php");
}
?>