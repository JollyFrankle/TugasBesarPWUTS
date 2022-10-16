<?php
session_start();
if (!($_SESSION["id"] ?? false) || !($_SESSION["user"]["role"] ?? false == "admin")) {
	die(json_encode(["status" => "error", "message" => "Anda tidak memiliki akses ke halaman ini"]));
}

include '../db.php';

$out_msg = ["Metode tidak valid!"];
$output = [
    "code" => 401,
    "message" => &$out_msg
];

if($_POST["action"] == "add" || $_POST["action"] == "edit") {
    // Reset output
    $out_msg = [];

    $judul = $_POST["judul"] ?? null;
    $jumlah = intval($_POST["jumlah"] ?? -1);
    $error = false;

    $id_buku = intval($_POST["id_buku"] ?? "0");

    if(empty($judul) || $jumlah < 0) {
        $error = true;
        $out_msg[] = "Semua field harus diisi!";
    }
    
    // if action is edit, then id_buku must be provided
    if($_POST["action"] == "edit" && $id_buku == 0) {
        $error = true;
        $out_msg[] = "ID buku tidak valid!";
    }

    // if action is add, then gambar must be uploaded
    if($_POST["action"] == "add" && !($_FILES["gambar"] ?? true)) {
        $error = true;
        $out_msg[] = "Gambar sampul buku harus diupload!";
    }

    $fileNameNew = null;
    if(!empty($_FILES["gambar"]["name"] ?? "") && !$error) {
        // handle file upload
        $file = $_FILES["gambar"] ?? null;
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
                        $fileNameNew = uniqid("fotobuku_", true) . "." . $fileActualExt;
                        $fileDestination = "../uploads/" . $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);

                        // Delete old file
                        $sql = "SELECT gambar FROM buku WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id_buku);
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
        if($_POST["action"] == "add") {
            $sql = "INSERT INTO buku (judul, jumlah, gambar) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sis", $judul, $jumlah, $fileNameNew);
            $stmt->execute();
            $out_msg[] = "Buku berhasil ditambahkan!";
        }
        if($_POST["action"] == "edit") {
            if($fileNameNew) {
                $sql = "UPDATE buku SET judul = ?, jumlah = ?, gambar = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sisi", $judul, $jumlah, $fileNameNew, $id_buku);
            } else {
                $sql = "UPDATE buku SET judul = ?, jumlah = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sii", $judul, $jumlah, $id_buku);
            }
            $stmt->execute();
            $out_msg[] = "Buku berhasil diubah!";
        }
        $output["code"] = 200;
    } else {
        $output["code"] = 400;
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
    <title>Add/Edit Buku Process</title>
</head>
<body class="body-flex-center bg">
    <div class="background-tint"></div>
    <div class="container-25rem m-3 shadow">
    <?php if($output["code"] == 200) { 
        /* Kalau sudah tidak ada salah, arahkan untuk login: */ ?>
        <div class="card" role="alert">
            <div class="card-header bg-success bg-opacity-25 fw-bold">Berhasil!</div>
            <div class="card-body">
                <ul class="list-custom mb-0">
                <?php foreach($output["message"] as $message) { ?>
                    <li><?php echo $message;?></li>
                <?php } ?>
                </ul>
                <a href="../page/Admin/Home.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Kembali ke Dashboard</a>
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