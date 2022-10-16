<?php include '../../components/header.php'; ?>
<div class="d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Tambah Buku</h4>
    <a class="btn btn-success" href="javascript:history.back()">Kembali</a>
</div>
<img src="../../assets/images/mc-villager.png" class="villager" />
<hr>
<div class="row">
    <form class="col-md-6 mb-3 needs-validation" id="form-tambah-buku" method="POST" enctype="multipart/form-data" action="../../process/addEditBuku.php">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukan Judul Buku" required>
            <div class="invalid-feedback">
                Judul Buku tidak boleh kosong!
            </div>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Buku</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukan Jumlah Buku" required min="0" max="127">
            <div class="invalid-feedback">
                jumlah Buku tidak boleh 0
            </div>
        </div>

        <div class="mb-4">
            <label for="sampul" class="form-label">Masukan Gambar Sampul Buku</label>
            <input class="form-control" type="file" name="gambar" id="sampul" onchange="preview()" accept=".jpg, .jpeg, .png" required>
        </div>

        <div class="">
            <button class="btn btn-primary" type="submit" name="action" value="add">
                <img src="../../assets/images/mc-icons/diamond_sword.png" class="mc-icon"> Tambah Buku</button>
        </div>
    </form>

    <div class="col-md-6 mb-3 text-center text-md-start">
        <p class="fw-bold mb-2">&mdash; PREVIEW</p>
        <img id="frame" src="../../assets/images/icon_lectern.webp" class="gambar-buku" >
    </div>
</div>
<?php include '../../components/footer.php'; ?>

<script>
    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }

    // let form = document.getElementById('form-tambah-buku');
    // form.addEventListener("submit", function(event) {
    //     return false;
    //     if (form.checkValidity() === false) {
    //         event.preventDefault();
    //         event.stopPropagation();
    //     }
    //     form.classList.add('was-validated');
    // });
</script>