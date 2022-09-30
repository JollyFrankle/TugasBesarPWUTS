<?php
include '../db.php';

session_start();
if($_SESSION["id"] ?? false){
    header("Location: ../page/homePage.php");
}

if($_POST["action"] ?? "" === "login") {
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;

    if($email && $password) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if(password_verify($password, $user["password"])) {
                $_SESSION["id"] = $user["id"];
                header("Location: ../page/homePage.php");
            } else {
                echo "Password salah";
            }
        } else {
            echo "Email tidak terdaftar";
        }
    } else {
        echo json_encode(["status" => 400, "message" => "Client error: parameter email, password harus ada di request POST."]);
    }
}

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link href="../style.css" rel="stylesheet">
    <title>Log in Process</title>
</head>
<body>
    <div class="bg bg-light text-dark">
        <div class="background-tint"></div>
        <div class="container min-vh-100 d-flex align-items-center justify-content-center">
            <div class="card text-white bg-dark ma-5 shadow" style="min-width: 25rem;">
            </div>
        </div>
    </div>
</body>
