<?php
include '../db.php';

session_start();
if($_SESSION["id"] ?? false){
    header("Location: ../page/homePage.php");
}

if($_POST["action"] ?? "" == "register") {
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;
    $nama = $_POST["nama"] ?? null;

    if($email && $password && $nama) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, password, nama) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $password, $nama);
        if($stmt->execute()) {
            header("Location: ../page/loginPage.php");
            echo "Berhasil";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo json_encode(["status" => 400, "message" => "Client error: parameter email, password, nama harus ada di request POST."]);
    }
}
?>

