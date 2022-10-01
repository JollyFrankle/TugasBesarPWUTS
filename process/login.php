<?php
include '../db.php';

session_start();
if($_SESSION["id"] ?? false){
    header("Location: ../page/homePage.php");
}

$output = [
    "code" => 401,
    "message" => [
        "Request method atau parameter tidak valid. Pastikan Anda mengakses halaman ini melalui form login."
    ]
];

if($_POST["action"] ?? "" === "login") {
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;

    if($email && $password) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if(password_verify($password, $user["password"])) {
                $_SESSION["id"] = $user["id"];
                $_SESSION["user"] = $user;
                if($user["role"] === "admin") {
                    $_SESSION["admin"] = true;
                    header("Location: ../page/HomeAdmin.php");
                } else {
                    header("Location: ../page/HomeUser.php");
                }
                exit;
            } else {
                $output = [
                    "code" => 401,
                    "message" => [
                        "Email atau password salah."
                    ]
                ];
            }
        } else {
            $output = [
                "code" => 401,
                "message" => [
                    "Email atau password salah."
                ]
            ];
        }
    } else {
        $output = [
            "code" => 400,
            "message" => [
                "Email atau password tidak boleh kosong."
            ]
        ];
    }
}

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link href="../assets/css/style.css" rel="stylesheet">
    <title>Log in Process</title>
</head>
<body class="body-flex-center bg">
    <div class="background-tint"></div>
    <div class="container-25rem m-3 shadow">
    <?php if($output["code"] != 200) { 
        /* Kalau ada kesalahan, maka tampilkan kesalahannya: */ ?>
        <div class="card" role="alert">
            <div class="card-header bg-danger bg-opacity-25 fw-bold">Terjadi kesalahan!</div>
            <div class="card-body">
                <ul class="list-custom mb-0">
                <?php foreach($output["message"] as $message) { ?>
                    <li><?php echo $message;?></li>
                <?php } ?>
                </ul>
                <!-- back button -->
                <a href="javascript:history.back()" class="btn btn-warning position-absolute" style="left: 1.25rem; bottom: 1.25rem;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="img-btmright">
                <img src="https://www.minecraft.net/content/dam/minecraft/creeper.png" alt="Creeper" />
            </div>
        </div>
    <?php } ?>
    </div>
</body>
