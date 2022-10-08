<?php
session_start();
if (!($_SESSION["id"] ?? false)) {
	header("Location: ./loginPage.php");
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

    $error = false;

    $judul = $_POST["judul"] ?? null;
    $konten = $_POST["konten"] ?? null;
    $id = $_POST["id"] ?? null;

    if(empty($judul) || empty($konten)) {
        $error = true;
        $out_msg[] = "Semua field harus diisi!";
    }

    if(!$error) {
        $tgl_mod = date("Y-m-d H:i:s");
        if($_POST["action"] == "add") {
            $sql = "INSERT INTO kritik_saran (id_user, judul, konten, tanggal_kirim) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $_SESSION["id"], $judul, $konten, $tgl_mod);
            $stmt->execute();
            $out_msg[] = "Kritik/saran berhasil ditambahkan!";
        }
        if($_POST["action"] == "edit") {
            $sql = "UPDATE kritik_saran SET judul = ?, konten = ?, tanggal_kirim = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $judul, $konten, $tgl_mod, $id);
            $stmt->execute();
            $out_msg[] = "Kritik/saran berhasil diubah!";
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
    <title>Add/Edit Saran/Kritik Process</title>
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
                <a href="../page/ListSaranKritikPage.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Lihat Kritik/Saranmu</a>
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