<?php include '../components/header.php'; 
$sesi = [
    1 => '1: 08.00 - 09.45',
    2 => '2: 10.00 - 11.45',
    3 => '3: 12.00 - 13.45',
    4 => '4: 14.00 - 15.45',
    5 => '5: 16.00 - 17.45',
];
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM reservasi_ruang_baca WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservasi = $result->fetch_assoc();
}
?>

<div class="d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Perbarui Reservasi Ruang Baca</h4>
    <a class="btn btn-success" href="javascript:history.back()">Kembali</a>
</div>
<img src="../assets/images/mc-villager.png" class="villager" />
<hr>
<div class="alert alert-primary" role="alert">
    Silahkan perbarui <strong> Reservasi Ruang Bacamu </strong>.
</div>
<div class="row" style="margin-bottom:15vw;">
    <form class="col-md-6 mb-3 needs-validation" id="form-reservasi-ruang" method="POST" enctype="multipart/form-data" action="../process/reservasiRuangUser.php">
        <div class="mb-3">
            <label for="id_ruang" class="form-label">Pilih Ruang</label>
            <select class="form-select" name="id_ruang" id="id_ruang" onchange="preview()"  required>
                <option disabled selected hidden> Pilih Ruangan </option>
                <?php
                    $query = mysqli_query($conn, "SELECT * FROM ruang_baca;") or die(mysqli_error($conn));
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <option value="<?php echo $data['id'] ?>" data-image="<?php echo $data['gambar'];?>"    <?php echo ($reservasi['id_ruang'] == $data['id']) ? 'selected' : '' ?>><?php echo $data['nama_ruang'] ?></option>
                <?php
                    }
                ?>
            </select>
            <div class="invalid-feedback">
                Ruang Baca harus dipilih!
            </div>
        </div>
        <div class="mb-3">
            <label for="tanggal_reservasi" class="form-label">Tanggal Reservasi</label>
            <input type="date" class="form-control" id="tanggal_reservasi" name="tanggal" value="<?php echo $reservasi['tanggal'] ?>" min="<?php echo date("Y-m-d");?>" required>
            <div class="invalid-feedback">
                Tanggal reservasi harus dipilih!
            </div>
        </div>
        <div class="mb-3">
            <label for="sesi" class="form-label">Waktu Peminjaman</label>
            <select class="form-select" name="sesi" id="sesi" required>
                <option disabled selected hidden> Pilih Waktu Peminjaman </option>
            <?php foreach ($sesi as $key => $value) { ?>
                <option value="<?php echo $key; ?>" <?php echo ($reservasi['sesi'] == $key ) ? "selected" : ''; ?> > <?php echo $value; ?> </option>
            <?php } ?>
            </select>
            <div class="invalid-feedback">
                Waktu Peminjaman harus dipilih!
            </div>
        </div>
        <div class="">
            <button class="btn btn-primary" type="submit" name="action" value="edit">
                <img src="../assets/images/mc-icons/diamond_sword.png" class="mc-icon"> Perbarui Reservasi Ruang
            </button>
            <input type="hidden" name="id" value="<?php echo $reservasi['id'] ?>">
        </div>
    </form>

    <div class="col-md-6 mb-3 text-center text-md-start">
        <p>Preview</p>
        <img id="gambar-ruangan" src="../assets/images/bgLogin.jpg" class="gambar-ruang w-100" >
    </div>
</div>
<?php include '../components/footer.php'; ?>

<script>
    document.getElementById('id_ruang').onchange = function() {
        document.getElementById('gambar-ruangan').src = '../assets/images/ruang-baca/' + this.options[this.selectedIndex].getAttribute('data-image');
    };
    // Trigger --> supaya gambar muncul saat halaman pertama kali di load
    document.getElementById('id_ruang').onchange();
</script>