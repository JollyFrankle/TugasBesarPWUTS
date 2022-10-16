<?php
include '../db.php';

session_start();
if($_SESSION["id"] ?? false){
    die(json_encode(["status" => "error", "message" => "Anda tidak memiliki akses ke halaman ini"]));
}

$out_msg = ["Request method atau parameter tidak valid. Pastikan Anda mengakses halaman ini melalui form login."];
$output = [
    "code" => 401,
    "message" => &$out_msg
];


if($_POST["action"] ?? "" == "register") {
    // Reset output message
    $out_msg = [];

    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;
    $nama = $_POST["nama"] ?? null;
    $error = false;

    if(!$email || !$password || !$nama) {
        $error = true;
        $out_msg[] = "Semua field harus diisi.";
    }

    // check if email already exist
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $error = true;
        $out_msg[] = "Email sudah terdaftar.";
    }

    if(strlen($password) < 8) {
        $error = true;
        $out_msg[] = "Password minimal 8 karakter!";
    }

    $fileNameNew = null;
    if(empty($_FILES["foto"]["name"] ?? "") && !$error) {
        $error = true;
        $out_msg[] = "Foto tidak boleh kosong.";
    }
    
    if(!$error) {
        // handle file upload
        $file = $_FILES["foto"] ?? null;
        $fileName = $file["name"] ?? null;
        $fileTmpName = $file["tmp_name"] ?? null;
        // check
        if($fileTmpName) {
            $fileSize = $file["size"];
            $fileError = $file["error"];
            $fileType = $file["type"];
            $fileExt = explode(".", $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = ["jpg", "jpeg", "png"];
            if(in_array($fileActualExt, $allowed)) {
                if($fileError === 0) {
                    if($fileSize < 2*1024*1024) {
                        $fileNameNew = uniqid("fotouser_", true) . "." . $fileActualExt;
                        $fileDestination = "../uploads/" . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                    } else {
                        $error = true;
                        $out_msg[] = "Ukuran file terlalu besar.";
                        $out_msg[] = "Ukuran file maksimal 2MB.";
                    }
                } else {
                    $error = true;
                    $out_msg[] = "Terjadi kesalahan tak terduga saat mengunggah file.";
                }
            } else {
                $error = true;
                $out_msg[] = "Ekstensi file tidak didukung.";
                $out_msg[] = "Ekstensi yang diizinkan: JPG, JPEG, dan PNG";
            }
        }
    }

    if(!$error) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (`email`, `password`, `nama`, `foto`, `role`) VALUES (?, ?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $email, $password, $nama, $fileNameNew);
        if($stmt->execute()) {
            $output = [
                "code" => 200
            ];
        } else {
            $output = [
                "code" => 500,
                "message" => [
                    "Terjadi kesalahan pada server. Silahkan coba lagi."
                ]
            ];
        }
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
    <?php if($output["code"] == 200) { 
        /* Kalau sudah tidak ada salah, arahkan untuk login: */ ?>
        <div class="card" role="alert">
            <div class="card-header bg-success bg-opacity-25 fw-bold">Selamat datang!</div>
            <div class="card-body">
                <p class="card-text">Silakan klik tombol di bawah ini untuk lanjut ke log in:</p>
                <a href="../page/Login.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Log in</a>
            </div>
            <div class="img-btmleft">
                <img src="../assets/images/mc-villager.png" alt="Librarian villager" />
            </div>
        </div>
    <?php } else { 
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