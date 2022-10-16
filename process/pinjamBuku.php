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

if($_POST["action"] ?? "" == "pinjam_buku") {
    // Reset output message
    $out_msg = [];

    $id_buku = intval($_POST["id_buku"] ?? "0");
    $id_user = $_SESSION["id"];
    $error = false;

    // Cek apakah jumlah buku > 0
    $sql = "SELECT jumlah FROM buku WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_buku);
    $stmt->execute();
    $result = $stmt->get_result();
    $jumlah_buku = $result->fetch_column();
    if($jumlah_buku <= 0) {
        $error = true;
        $out_msg[] = "Stok buku yang ingin dipinjam sudah habis.";
    }

    $buku = null;
    if(!$error) {
        // Dapaatkan detail buku yangi ngin dipinjam
        $sql = "SELECT * FROM buku WHERE id = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_buku);
        $stmt->execute();
        $result = $stmt->get_result();
        $buku = $result->fetch_assoc();

        // Add to peminjaman
        $sql = "INSERT INTO peminjaman (`id_buku`, `id_user`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES (?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $tanggal_pinjam = date("Y-m-d");
        $tanggal_kembali = date("Y-m-d", strtotime("+7 days"));

        $stmt->bind_param("iiss", $id_buku, $id_user, $tanggal_pinjam, $tanggal_kembali);
        $stmt->execute();

        // Update jumlah buku
        $sql = "UPDATE buku SET jumlah = jumlah - 1 WHERE id = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_buku);
        $stmt->execute();

        $output = [
            "code" => 200,
            "message" => [
                "Berhasil meminjam buku."
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
    <title>Proses Peminjaman Buku</title>
</head>
<body class="body-flex-center bg">
    <div class="background-tint"></div>
    <div class="container-25rem m-3 shadow">
    <?php if($output["code"] == 200) { 
        /* Kalau sudah tidak ada salah, arahkan untuk login: */ ?>
        <div class="card" role="alert">
            <div class="card-header bg-success bg-opacity-25 fw-bold">Peminjaman berhasil!</div>
            <div class="card-body">
                <p class="card-text">Buku <strong><?php echo htmlspecialchars($buku["judul"]);?></strong> berhasil dipinjam dan wajib dikembalikan pada <strong><?php echo date('j F Y', strtotime($tanggal_kembali));?></strong>.</p>
                <a href="../page/User/ListPeminjaman.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Lihat daftar peminjaman</a>
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