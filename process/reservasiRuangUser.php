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

    $tanggal = $_POST["tanggal"] ?? null;
    $sesi = intval($_POST["sesi"] ?? "0");
    $id_reservasi = intval($_POST["id"] ?? "0");
    $id_ruang = intval($_POST["id_ruang"] ?? "0");

    if(empty($tanggal) || empty($sesi) || empty($id_ruang)) {
        $error = true;
        $out_msg[] = "Semua field harus diisi!";
    }

    // validate tanggal: must be in the future
    $tanggal = date_create_from_format("Y-m-d", $tanggal);
    if($tanggal < date_create()) {
        $error = true;
        $out_msg[] = "Tanggal pemakaian tidak boleh <= hari ini!";
    }

    // validate sesi: must be 1 to 5
    if($sesi < 1 || $sesi > 5) {
        $error = true;
        $out_msg[] = "Sesi tidak valid!";
    }

    // if action is edit, then id_reservasi must be provided
    if($_POST["action"] == "edit" && $id_reservasi == 0) {
        $error = true;
        $out_msg[] = "ID reservasi tidak valid!";
    }

    // Check akapah ruang bisa dipinjam?
    $tanggal = $tanggal->format("Y-m-d");
    if($_POST["action"] == "add") {
        $sql = "SELECT * FROM `reservasi_ruang_baca` WHERE `tanggal` = ? AND `sesi` = ? AND `id_ruang` = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $tanggal, $sesi, $id_ruang);
    } else {
        $sql = "SELECT * FROM `reservasi_ruang_baca` WHERE `tanggal` = ? AND `sesi` = ? AND `id_ruang` = ? AND `id` != ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siii", $tanggal, $sesi, $id_ruang, $id_reservasi);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_column();
    if($count > 0) {
        $error = true;
        $out_msg[] = "Ruang ini sudah terpakai pada sesi tersebut!";
    }

    if(!$error) {
        if($_POST["action"] == "add") {
            $sql = "INSERT INTO `reservasi_ruang_baca` (`id_user`, `id_ruang`, `tanggal`, `sesi`, `status`) VALUES (?, ?, ?, ?, 0);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisi", $_SESSION["id"], $id_ruang, $tanggal, $sesi);
            $stmt->execute();
            $out_msg[] = "Reservasi berhasil ditambahkan!";
        }
        if($_POST["action"] == "edit") {
            $sql = "UPDATE `reservasi_ruang_baca` SET `id_ruang` = ?, `tanggal` = ?, `sesi` = ?, `status` = 0 WHERE `id` = ?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isii", $id_ruang, $tanggal, $sesi, $id_reservasi);
            $stmt->execute();
            $out_msg[] = "Reservasi berhasil diubah!";
        }
        $output["code"] = 200;
    } else {
        $output["code"] = 400;
    }
}

if(($_POST["action"] ?? "") == "hapus_reservasi") {
    // Reset output
    $out_msg = [];

    $error = false;
    $id = intval($_POST["id_reservasi"]);

    // get data Reservasi
    $sql = "SELECT * FROM reservasi_ruang_baca WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $kritikSaran = $result->fetch_assoc();
    if(!$kritikSaran) {
        $error = true;
        $out_msg[] = "Reservasi Ruang baca tidak ditemukan.";
    }

    if(!$error) {
    //  Delete Reservasi RUang baca
        $id = intval($_POST["id_reservasi"]);
        $sql = "DELETE FROM reservasi_ruang_baca WHERE id = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $output = [
            "code" => 200
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
    <title>Reservasi Ruang Baca Process</title>
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
                <a href="../page/DaftarReservasiRuangPage.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Lihat Reservasi</a>
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