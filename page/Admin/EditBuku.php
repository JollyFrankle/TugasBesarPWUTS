<?php include '../../components/header.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM buku WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();
}
?>

<div class="body d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Edit Buku</h4>
    <a href="javascript:history.back()" class="btn btn-success">Kembali</a>
</div>
<img src="../../assets/images/mc-villager.png" class="villager"/>
<hr>
<div class="row" style="margin-bottom:15vw;">
    <form class="col-md-6 mb-3 needs-validation" method="POST" action="../../process/addEditBuku.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukan Judul Buku" value="<?php echo @$buku['judul'] ?>" required>
            <div class="invalid-feedback">
                Judul Buku tidak boleh kosong!
            </div>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Buku</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukan Jumlah Buku" value="<?php echo @$buku['jumlah'] ?>" required min="0" max="127">
            <div class="invalid-feedback">
                jumlah Buku tidak boleh 0
            </div>
        </div>

        <div class="mb-4">
            <label for="sampul" class="form-label mb-0">Masukan Gambar Sampul Buku</label>
            <div class="small text-muted mb-2">Kosongkan jika tidak ingin diubah</div>
            <input class="form-control" type="file" id="sampul" name="gambar" onchange="preview()" accept=".jpg, .jpeg, .png">
        </div>

        <div class="">
            <button class="btn btn-primary" type="submit" name="action" value="edit">
                <img src="../../assets/images/mc-icons/trident.png" class="mc-icon"> Perbarui
            </button>
            <input type="hidden" name="id_buku" value="<?php echo @$buku['id'] ?>">
        </div>
    </form>
    <div class="col-md-6 text-center text-md-start">
        <p class="fw-bold mb-2">&mdash; PREVIEW</p>
        <img id="frame" src="../../uploads/<?php echo @$buku['gambar'] ?>" class="gambar-buku">
    </div>
</div>
<?php include '../../components/footer.php'; ?>

<script>
    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }
</script>