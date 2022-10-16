<?php
session_start();
if (!($_SESSION["id"] ?? false)) {
	die(json_encode(["status" => "error", "message" => "Anda tidak memiliki akses ke halaman ini"]));
}

include '../db.php';

$out_msg = ["Metode tidak valid!"];
$output = [
    "code" => 401,
    "message" => &$out_msg
];

if($_POST["action"] == "edit_user") {
    // Reset output message
    $out_msg = [];

    $error = false;
    $nama = $_POST["nama"] ?? "";
    $email = $_POST["email"] ?? $_SESSION["user"]["email"]; // fallback karena kalau input 'disabled', maka tidak akan dikirim ke sini
    $password = $_POST["password"] ?? "";

    if(empty($nama) && empty($email)) {
        $error = true;
        $out_msg[] = "Nama dan email tidak boleh kosong!";
    }

    // check if email already exist
    $sql = "SELECT * FROM users WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $_SESSION["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $error = true;
        $out_msg[] = "Email sudah terdaftar.";
    }

    if(!empty($password)) {
        // if(strlen($password) < 8) {
        //     $error = true;
        //     $out_msg[] = "Password minimal 8 karakter!";
        // } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        // }
    }

    $fileNameNew = null;
    if(!empty($_FILES["foto"]["name"] ?? "") && !$error) {
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
                    if($fileSize < 8*1024*1024) {
                        $fileNameNew = uniqid("fotouser_", true) . "." . $fileActualExt;
                        $fileDestination = "../uploads/" . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);

                        // Delete old file
                        $sql = "SELECT foto FROM users WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $_SESSION["id"]);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $old_foto = $result->fetch_column();
                        if($old_foto) {
                            unlink("../uploads/" . $old_foto);
                        }
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
        if($fileNameNew && $password) {
            $sql = "UPDATE users SET `nama` = ?, `email` = ?, `password` = ?, `foto` = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $nama, $email, $password, $fileNameNew, $_SESSION["id"]);
        } else if($fileNameNew) {
            $sql = "UPDATE users SET `nama` = ?, `email` = ?, `foto` = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nama, $email, $fileNameNew, $_SESSION["id"]);
        } else if($password) {
            $sql = "UPDATE users SET `nama` = ?, `email` = ?, `password` = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nama, $email, $password, $_SESSION["id"]);
        } else {
            $sql = "UPDATE users SET `nama` = ?, `email` = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $nama, $email, $_SESSION["id"]);
        }
        if($stmt->execute()) {
            $output = [
                "code" => 200
            ];

            // Update session
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION["id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $_SESSION["user"] = $result->fetch_assoc();
        } else {
            $output = [
                "code" => 500,
                "message" => [
                    "Terjadi kesalahan saat mengubah data user."
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
    <title>User Process</title>
</head>
<body class="body-flex-center bg">
    <div class="background-tint"></div>
    <div class="container-25rem m-3 shadow">
    <?php if($output["code"] == 200) { 
        /* Kalau sudah tidak ada salah, arahkan untuk login: */ ?>
        <div class="card" role="alert">
            <div class="card-header bg-success bg-opacity-25 fw-bold">Perubahan data berhasil!</div>
            <div class="card-body">
                <p class="card-text">Silakan klik tombol ini untuk kembali ke halaman profil:</p>
                <a href="../page/Profile/View.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Lihat Profile</a>
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