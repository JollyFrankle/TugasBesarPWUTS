<?php include '../../components/header.php'; ?>

<div class="body d-flex justify-content-between">
    <h4 class="mb-0">Saran Kritik</h4>
    <a href="./ListKritikSaran.php" class="btn btn-success">Kembali</a>
    <img src="../../assets/images/mc-villager-new.webp" class="villager2" />
</div>
</div>
<hr>
<div class="alert alert-primary" role="alert">
    <p><strong>Saran/kritik</strong>  yang diberikan akan memajukan <strong>Minecraft library</strong>  ini menjadi yang lebih baik.</p>
    <p class="mb-0">Saran dan kritik Anda dibatasi 255 karakter.</p>
</div>

<div class="row" style="margin-bottom:15vw;">
    <form class="col-lg-8 col-xl-6 mb-3 needs-validation" id="form-kritsar" method="POST" action="../../process/addEditSaranKritik.php">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukan Judul" required maxlength="100">
            <div class="invalid-feedback">
                Judul tidak boleh kosong!
            </div>
        </div>
        <div class="mb-3">
            <label for="konten" class="form-label">Kritik / Saran</label>
            <textarea class="form-control" name="konten" id="konten" rows="5" placeholder="Masukkan Kritik/Saran (max 255 karakter)" required maxlength="255"></textarea>
            <div class="invalid-feedback">
                Kritik / Saran tidak boleh Kosong!
            </div>
        </div>


        <div class="">
            <button class="btn btn-primary" type="submit" name="action" value="add">
                <img src="../../assets/images/mc-icons/diamond_sword.png" class="mc-icon" style="height: 30px;"> Tambah Kritik/Saran
            </button>
        </div>
    </form>

</div>

<?php include '../../components/footer.php'; ?>