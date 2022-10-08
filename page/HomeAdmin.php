<?php include '../components/header.php'; ?>
<div class="body d-flex justify-content-between">
    <h4 class="mb-0">Home Admin</h4>
    <img src="../assets/images/mc-villager.png" class="villager"/>
</div>
<hr>
<div class="table-responsive" style="margin-bottom:15vw;">
    <table class="table table-hover rounded rounded-1 overflow-hidden align-middle">
        <thead class="text-nowrap">
            <tr class="table-dark">
                <th scope="col" class="text-center">No</th>
                <th scope="col">Judul Buku</th>
                <th scope="col" class="text-center">Gambar</th>
                <th scope="col" class="text-center">Jumlah Tersedia</th>
                <th scope="col" class="text-center">Edit / Hapus</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM buku;") or
                die(mysqli_error($conn));
            if (mysqli_num_rows($query) == 0) {
                echo '<tr> <td colspan="7"> Tidak ada data </td> </tr>';
            } else {
                $no = 1;
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <th scope="row" class="text-center"><?php echo $no; ?></th>
                        <td><?php echo $data['judul']; ?></td>
                        <td class="text-center"><img src="../uploads/<?php echo $data['gambar']; ?>" class="gambar-buku-sm"/></td>
                        <td class="text-center"><?php echo $data['jumlah']; ?></td>
                        <td class="text-center">
                            <a href='./EditBuku.php?id=<?php echo $data['id']; ?>' class="btn btn-light">
                                <img src="../assets/images/mc-icons/netherite_pickaxe.png" class="mc-icon" width="30rem" />
                            </a>
                            <button onclick="hapusBuku(this);" class="btn btn-light" data-json='<?php echo json_encode($data); ?>'>
                                <img src="../assets/images/mc-icons/barrier.png" class="mc-icon" width="30rem" />
                            </button>
                        </td>
                    </tr>
            <?php $no++;
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php include '../components/footer.php'; ?>

<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin menghapus buku <strong id="namaBuku"></strong>?
            </div>
            <form class="modal-footer" action="../process/penghapusanBuku.php" method="POST">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="action" value="hapus_buku">Hapus</button>
                <input type="hidden" name="id_buku" id="idBuku" />
            </form>
        </div>
    </div>
</div>
<script>
    function hapusBuku(element) {
        var data = JSON.parse(element.getAttribute('data-json'));
        document.getElementById('namaBuku').innerHTML = data.judul;
        document.getElementById('idBuku').value = data.id;

        bootstrap.Modal.getOrCreateInstance(document.getElementById("hapusModal")).show();
        // $('#pengembalianModal').modal('show');
    }
</script>