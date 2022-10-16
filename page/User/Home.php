<?php include '../../components/header.php'; ?>

<!-- <div class="container p-3 m-4 h-100" style="background-color: #FFFFFF; border-top: 5px solid #000000; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"> -->
<div class="body d-flex justify-content-between">
    <h4 class="mb-0">Daftar Buku</h4> 
    <img src="../../assets/images/mc-villager.png"class="villager"/>
</div>
<hr>

<div class="alert alert-primary" role="alert">
    <strong>Selamat datang di Perpustakaan Minecraft</strong>. Silahkan pilih buku yang ingin kamu pinjam.
</div>

<div class="table-responsive" style="margin-bottom:15vw;">
    <table class="table table-hover rounded rounded-1 overflow-hidden align-middle">
        <thead class="text-nowrap">
            <tr class="table-dark">
                <th scope="col" style="text-align:center">No</th>
                <th scope="col">Judul Buku</th>
                <th scope="col" style="text-align:center">Gambar</th>
                <th scope="col" style="text-align:center">Jumlah Tersedia</th>
                <th scope="col" style="text-align:center">Pinjam</th>
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
                        <th scope="row" style="text-align:center"><?php echo $no; ?></th>
                        <td><?php echo $data['judul']; ?></td>
                        <td style="text-align:center"><img src="../../uploads/<?php echo $data['gambar']; ?>" class="gambar-buku-sm"/></td>
                        <td style="text-align:center"><?php echo $data['jumlah']; ?></td>
                        <td style="text-align:center">
                            <button onclick="pinjamBuku(this);" class="btn btn-light" data-json='<?php echo json_encode($data); ?>'>
                                <img src="../../assets/images/mc-icons/book.png" class="mc-icon" width="30rem" />
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

<?php include '../../components/footer.php'; ?>

<!-- Modal -->
<div class="modal fade" id="peminjamanModal" tabindex="-1" aria-labelledby="peminjamanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="peminjamanModalLabel">Konfirmasi Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin meminjam buku ini:</p>
                <div class="text-center mb-3">
                    <img class="gambar-buku" id="fotoBuku" />
                </div>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Judul</th>
                            <td id="judulBuku"></td>
                        </tr>
                        <tr>
                            <th scope="row">Tanggal Pinjam</th>
                            <td><?php echo date('j F Y'); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Tanggal Kembali</th>
                            <td><?php echo date('j F Y', strtotime("+7 days")); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Jumlah Buku Dipinjam</th>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>
                <p class="mb-0">Buku tidak akan bisa dipinjam kalau stoknya kosong.</p>
            </div>
            <form class="modal-footer" action="../../process/pinjamBuku.php" method="POST">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="action" value="pinjam">Pinjam</button>
                <input type="hidden" name="id_buku" id="idBuku" />
            </form>
        </div>
    </div>
</div>
<script>
    function pinjamBuku(element) {
        var data = JSON.parse(element.getAttribute('data-json'));
        document.getElementById('judulBuku').innerHTML = data.judul;
        document.getElementById('fotoBuku').src = "../../uploads/" + data.gambar;
        document.getElementById('idBuku').value = data.id;

        bootstrap.Modal.getOrCreateInstance(document.getElementById("peminjamanModal")).show();
        // $('#peminjamanModal').modal('show');
    }
</script>