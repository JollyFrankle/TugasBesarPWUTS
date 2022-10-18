<?php include '../../components/header.php';

$cek = $_SESSION["user"];

?>
<div class="d-flex justify-content-between mb-4">
    <h4 class="mb-0">Data Akun</h4>
</div>

<img src="../../assets/images/mc-villager.png" class="villager" />

<div class="card card-body shadow" style="border-top: .25rem solid var(--bs-green);">
    <div class="row text-center text-md-start align-items-center">
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <img id="frame" src="<?php echo $cek["foto"] != null ? "../../uploads/" . $cek["foto"] : "../../assets/images/icon_user.png"; ?>" style="width: 80%;" class="gambar-buku">
        </div>
        <div class="col-xl-9 col-lg-8 col-md-6 mb-4">
            <h4> Halo, <?php echo htmlspecialchars($cek['nama']) ?> 👋👋👋</h4>
            <p class="lead fw-normal mb-4"> Kamu sedang login menggunakan email <strong><?php echo htmlspecialchars($cek['email']);?></strong>.</p>
            <p class=""><em>Ingin memperbarui profil?</em></p>
            <a href="./Edit.php" class="btn btn-success">Edit Profil</a>
            <!-- <a href="." class="btn btn-danger">Hapus Akun</a> -->
        </div>
    </div>
</div>

<?php include '../../components/footer.php'; ?>