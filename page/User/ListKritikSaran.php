<?php include '../../components/header.php'; ?>

<div class="body d-flex justify-content-between align-items-center">
    <h4 class="mb-0">List Saran Kritik</h4>
    <a href="./TambahKritikSaran.php" class="btn btn-success">Tambah</a>
    <img src="../../assets/images/mc-villager-new.webp" class="villager2" />
</div>
</div>
<hr>
<div class="row" data-masonry='{"percentPosition": true }' style="margin-bottom: 15vw;">
    <?php
    $id_user = $_SESSION['id'];
    $query = mysqli_query($conn, "SELECT * FROM kritik_saran WHERE id_user = $id_user;") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) == 0) { ?>
        <div class="col">
            <div class="alert alert-warning" role="alert">
                Anda belum pernah mengirimkan kritik dan saran
            </div>
        </div>
    <?php } else {
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) { ?>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header py-2 small flex-between">
                        <div class="small">
                            <?php echo date('j F Y, H.i.s', strtotime($data['tanggal_kirim'])); ?> WIB
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="flex-between mb-2">
                            <h5 class="card-title mb-0"><?php echo $data['judul']; ?></h5>
                            <div class="text-nowrap">
                                <a href="./EditKritikSaran.php?id=<?php echo $data['id']; ?>" class="btn btn-light"><img src="../../assets/images/mc-icons/diamond_pickaxe.png" class="mc-icon" style="height: 30px;"></a>
                                <button onclick="hapusKritikSaran(this);" class="btn btn-light" data-json='<?php echo json_encode($data); ?>'>
                                    <img src="../../assets/images/mc-icons/barrier.png" class="mc-icon" width="30rem" />
                                </button>
                            </div>
                        </div>

                        <p class="card-text" style="text-align: justify;"><?php echo nl2br($data['konten']); ?></p>
                    </div>
                </div>
            </div>
    <?php }
    } ?>
</div>

<?php include '../../components/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>

<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin menghapus Kritik Saran <strong><span id="judul"></span> </strong> ?
            </div>
            <form class="modal-footer" action="../../process/hapusKritikSaran.php" method="POST">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="action" value="hapus_kritikSaran">Hapus</button>
                <input type="hidden" name="id_KritikSaran" id="id_KritikSaran" />
            </form>
        </div>
    </div>
</div>

<script>
    function hapusKritikSaran(element) {
        var data = JSON.parse(element.getAttribute('data-json'));
        document.getElementById('judul').innerHTML = data.judul;
        document.getElementById('id_KritikSaran').value = data.id;

        bootstrap.Modal.getOrCreateInstance(document.getElementById("hapusModal")).show();
    }
</script>