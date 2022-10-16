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

$kritikSaran = [];
if($_POST["action"] ?? "" == "hapus_kritikSaran") {
    // Reset output
    $out_msg = [];

    $error = false;
    $id = intval($_POST["id_KritikSaran"]);

    // get data Kritik Saran
    $sql = "SELECT * FROM kritik_saran WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $kritikSaran = $result->fetch_assoc();
    if(!$kritikSaran) {
        $error = true;
        $out_msg[] = "Kritik Saran tidak ditemukan.";
    }

    if(!$error) {
    //  Delete Kritik Saran
        $id = intval($_POST["id_KritikSaran"]);
        $sql = "DELETE FROM kritik_saran WHERE id = ?;";
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
    <title>Proses Penghapusan Kritik Saran</title>
</head>
<body class="body-flex-center bg">
    <div class="background-tint"></div>
    <div class="container-25rem m-3 shadow">
    <?php if($output["code"] == 200) { 
        /* Kalau sudah tidak ada salah, arahkan untuk login: */ ?>
        <div class="card" role="alert">
            <div class="card-header bg-success bg-opacity-25 fw-bold">Penghapusan berhasil!</div>
            <div class="card-body">
                <p class="card-text">Penghapusan kritik saran <strong><?php echo @$kritiksaran["judul"];?></strong> berhasil dilakukan.</p>
                <a href="../page/User/ListKritikSaran.php" class="btn btn-primary position-absolute" style="right: 1.25rem; bottom: 1.25rem;">Ke List Saran Kritik</a>
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