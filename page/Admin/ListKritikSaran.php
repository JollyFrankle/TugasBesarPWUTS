<?php include '../../components/header.php'; ?>

<div class="body d-flex justify-content-between align-items-center">
    <h4 class="mb-0">List Saran Kritik</h4>
    <img src="../../assets/images/mc-villager-new.webp" class="villager2" />
</div>
</div>
<hr>
<div class="row" data-masonry='{"percentPosition": true }' style="margin-bottom: 15vw;">
    <?php
    $id_user = $_SESSION['id'];
    $query = mysqli_query($conn, "SELECT * FROM kritik_saran order by id desc") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) == 0) { ?>
        <div class="alert alert-warning" role="alert">
            Anda belum pernah mengirimkan kritik dan saran
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