<?php include '../components/header.php'; 
    if (isset($_GET['id'])) {
        include('../db.php');
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM kritik_saran WHERE id = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $kritik_saran = $result->fetch_assoc();
    }
?>

<div class="body d-flex justify-content-between">
    <h4 class="mb-0">Saran Kritik</h4>
    <a href="./ListSaranKritikPage.php" class="btn btn-success">Kembali</a>
    <img src="../assets/images/mc-villager-new.webp" class="villager2" />
</div>
</div>
<hr>

<div class="alert alert-primary" role="alert">
    Dengan <strong>saran / kritik</strong>  yang diberikan akan memajukan <strong>Minecraft library</strong>  ini menjadi yang lebih baik
</div>

<div class="row" style="margin-bottom:15vw;">
    <form class="col-lg-8 col-xl-6 mb-3 needs-validation" id="form-kritsar" method="POST" action="../process/addEditSaranKritik.php">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukan Judul" value="<?php echo $kritik_saran ['judul'] ?>" required>
            <div class="invalid-feedback">
                Judul tidak boleh kosong!
            </div>
        </div>
        <div class="mb-3">
            <label for="konten" class="form-label">Kritik / Saran</label>
            <textarea class="form-control" name="konten" id="konten" rows="5" placeholder="Masukkan Kritik/Saran" required><?php echo $kritik_saran ['konten'] ?></textarea>
            <div class="invalid-feedback">
                Kritik / Saran tidak boleh Kosong!
            </div>
        </div>


        <div class="">
            <button class="btn btn-primary" type="submit" name="action" value="edit">
                <img src="../assets/images/mc-icons/diamond_pickaxe.png" class="mc-icon" style="height: 30px;"> Update Kritik/Saran
            </button>
            <input type="hidden" name="id" value="<?php echo $kritik_saran ['id'] ?>">
        </div>
    </form>

</div>

<?php include '../components/footer.php'; ?>