<?php
session_start();
if (!($_SESSION["id"] ?? false) || !($_SESSION["user"]["role"] ?? false == "admin")) {
	header("Location: ./loginPage.php");
}

include '../db.php';

$out_msg = ["Metode tidak valid!"];
$output = [
    "code" => 401,
    "message" => &$out_msg
];

$buku = [];
if($_POST["action"] ?? "" == "hapus_buku") {
    // Reset output
    $out_msg = [];

    $error = false;
    $id = intval($_POST["id_buku"]);

    // get data buku
    $sql = "SELECT * FROM buku WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();
    if(!$buku) {
        $error = true;
        $out_msg[] = "Buku tidak ditemukan.";
    }

    if(!$error) {
        // cek apakah buku ini sedang dipinjam?
        $sql = "SELECT * FROM peminjaman WHERE id_buku = ? AND status = 1;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $error = true;
            $out_msg[] = "Buku ini sedang dipinjam.";
        } else {
            // Delete from peminjaman
            $sql = "DELETE FROM peminjaman WHERE id_buku = ?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Delete from buku
            $sql = "DELETE FROM buku WHERE id = ?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $output = [
                "code" => 200
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
    <title>Proses Peminjaman Buku</title>
</head>
<body class="body-flex-center bg">
    <div class="background-tint"></div>
    <div class="container-25rem m-3 shadow">
    <?php if($output["code"] == 200) { 
        /* Kalau sudah tidak ada salah, arahkan untuk login: */ ?>
        <div class="card" role="alert">
            <div class="card-header bg-success bg-opacity-25 fw-bold">Penghapusan berhasil!</div>
            <div class="card-body">
                <p class="card-text">Penghapusan buku <strong><?php echo @$buku["judul"];?></strong> berhasil dilakukan.</p>
                <a href="../page/HomeAdmin.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Ke dashboard</a>
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