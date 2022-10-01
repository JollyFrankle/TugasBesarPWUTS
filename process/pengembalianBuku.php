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

if($_POST["action"] ?? "" == "kembalikan_buku") {
    // Reset output message
    $out_msg = [];

    $id_peminjaman = intval($_POST["id_peminjaman"] ?? "0");
    $id_user = $_SESSION["id"];
    $error = false;

    // Cek apakah buku ini layak dikembalikan?
    $sql = "SELECT COUNT(*) FROM peminjaman WHERE id = ? AND id_user = ? AND status = 1;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_peminjaman, $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $jumlah_buku = $result->fetch_column();
    if($jumlah_buku <= 0) {
        $error = true;
        $out_msg[] = "Buku ini tidak ditemukan di daftar peminjaman.";
        $out_msg[] = "Mungkin buku ini sudah pernah dikembalikan sebelumnya.";
    }

    $buku = null;
    $tanggal_kembali = date("Y-m-d");
    if(!$error) {
        // Dapatkan detail buku yang ingin dikembalikan
        $sql = "SELECT * FROM buku WHERE id = (SELECT id_buku FROM peminjaman WHERE id = ?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_peminjaman);
        $stmt->execute();
        $result = $stmt->get_result();
        $buku = $result->fetch_assoc();

        // Update peminjaman
        $sql = "UPDATE peminjaman SET status = 0, tanggal_kembali = ? WHERE id = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $tanggal_kembali, $id_peminjaman);
        $stmt->execute();

        // Update jumlah buku
        $sql = "UPDATE buku SET jumlah = jumlah + 1 WHERE id = (SELECT id_buku FROM peminjaman WHERE id = ?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_peminjaman);
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
    <title>Proses Peminjaman Buku</title>
</head>
<body class="body-flex-center bg">
    <div class="background-tint"></div>
    <div class="container-25rem m-3 shadow">
    <?php if($output["code"] == 200) { 
        /* Kalau sudah tidak ada salah, arahkan untuk login: */ ?>
        <div class="card" role="alert">
            <div class="card-header bg-success bg-opacity-25 fw-bold">Pengembalian berhasil!</div>
            <div class="card-body">
                <p class="card-text">Buku <strong><?php echo htmlspecialchars($buku["judul"]);?></strong> berhasil dikembalikan pada <strong><?php echo date('j F Y', strtotime($tanggal_kembali));?></strong>.</p>
                <a href="../page/DaftarPeminjamanPage.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Lihat daftar peminjaman</a>
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