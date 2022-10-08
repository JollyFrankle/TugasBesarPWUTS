<?php include '../components/header.php'; ?>

<!-- <div class="container p-3 m-4 h-100" style="background-color: #FFFFFF; border-top: 5px solid #000000; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"> -->
<div class="body d-flex justify-content-between">
    <h4 class="mb-0">Daftar Peminjaman</h4>
    <img src="../assets/images/mc-villager.png" class="villager"/>
</div>
</div>
<hr>

<div class="alert alert-primary" role="alert">
    Halaman ini menampilkan daftar buku yang kamu pinjam. Jika kamu ingin mengembalikan buku, silahkan klik tombol <strong>Kembalikan</strong>.
</div>

<div class="table-responsive" style="margin-bottom:15vw;">
    <table class="table table-hover rounded rounded-1 overflow-hidden ">
        <thead class="text-nowrap">
            <tr class="table-dark">
                <th scope="col" style="text-align:center">No</th>
                <th scope="col">Nama Buku</th>
                <th scope="col" style="text-align:center">Gambar</th>
                <th scope="col" style="text-align:center">Status</th>
                <th scope="col" style="text-align:center">Tanggal Pengembalian</th>
                <th scope="col" style="text-align:center">Pengembalian Buku</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $query = "SELECT *, p.id AS id_peminjaman FROM peminjaman p join buku b on (p.id_buku = b.id) WHERE p.id_user = ?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                echo '<tr> <td colspan="7"> Tidak ada data </td> </tr>';
            } else {
                $no = 1;
                while ($data = $result->fetch_assoc()) { ?>
                    <tr class="align-middle">
                        <th scope="row" style="text-align:center"><?php echo $no; ?></th>
                        <td><?php echo $data['judul']; ?></td>
                        <td style="text-align:center"><img src="../uploads/<?php echo $data['gambar']; ?>" class="gambar-buku-sm"/></td>
                        <td style="text-align:center"><?php echo $data['status'] == 1 ? "Sedang dipinjam" : "Sudah dikembalikan"; ?></td>
                        <td style="text-align:center"><?php echo date('j F Y', strtotime($data['tanggal_kembali'])); ?></td>
                        <td style="text-align:center">
                        <?php if($data["status"] == 1) { ?>
                            <button onclick="pengembalianBuku(this);" class="btn btn-light" data-json='<?php echo json_encode($data); ?>'>
                                <img src="../assets/images/mc-icons/enchanted_book.png" class="mc-icon" width="30rem" />
                            </button>
                        <?php } ?>
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

<div class="modal fade" id="pengembalianModal" tabindex="-1" aria-labelledby="pengembalianModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengembalianModalLabel">Konfirmasi Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin mengembalikan buku <span id="namaBuku"></span>
            </div>
            <form class="modal-footer" action="../process/pengembalianBuku.php" method="POST">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="action" value="kembalikan_buku">Kembalikan</button>
                <input type="hidden" name="id_peminjaman" id="idPeminjaman" />
            </form>
        </div>
    </div>
</div>

<script>
    function pengembalianBuku(element) {
        var data = JSON.parse(element.getAttribute('data-json'));
        document.getElementById('namaBuku').innerHTML = data.judul;
        document.getElementById('idPeminjaman').value = data.id_peminjaman;

        bootstrap.Modal.getOrCreateInstance(document.getElementById("pengembalianModal")).show();
        // $('#pengembalianModal').modal('show');
    }
</script>