<?php
session_start();

if(!isset($_SESSION["user"]["role"])) {
    header("Location: ./Login.php");
}
if(($_SESSION["user"]["role"] ?? "") === "admin"){
    header("Location: ./Admin/Home.php");
} else if(($_SESSION["user"]["role"] ?? "") === "user"){
    header("Location: ./User/Home.php");
}
?>