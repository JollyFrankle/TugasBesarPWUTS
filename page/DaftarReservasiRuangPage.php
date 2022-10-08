<?php include '../components/header.php';
$sesi = [
    1 => '1: 08.00 - 09.45',
    2 => '2: 10.00 - 11.45',
    3 => '3: 12.00 - 13.45',
    4 => '4: 14.00 - 15.45',
    5 => '5: 16.00 - 17.45',
];
?>

<!-- <div class="container p-3 m-4 h-100" style="background-color: #FFFFFF; border-top: 5px solid #000000; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"> -->
<div class="flex-between">
    <h4 class="mb-0">Daftar Reservasi Ruang Baca</h4>
    <img src="../assets/images/mc-villager.png" class="villager" />
</div>
<hr>

<div class="alert alert-primary" role="alert">
    Halaman ini menampilkan Daftar Ruang Baca yang <strong>telah kamu reservasi.</strong> Silahkan diperiksa kembali.
</div>

<h4>Jadwal Sesi dan Ruangan</h4>
<div class="row">
    <div class="col-lg-4 mb-3">
        <h5 class="fw-bold text-primary">Jadwal Sesi Reservasi</h5>
        <ul class="list-group">
            <li class="list-group-item flex-between">
                <p class="fw-bold mb-0">Sesi 1</p>
                <p class="mb-0">08.00 &ndash; 09.45</p>
            </li>
            <li class="list-group-item flex-between">
                <p class="fw-bold mb-0">Sesi 2</p>
                <p class="mb-0">10.00 &ndash; 11.45</p>
            </li>
            <li class="list-group-item flex-between">
                <p class="fw-bold mb-0">Sesi 3</p>
                <p class="mb-0">12.00 &ndash; 13.45</p>
            </li>
            <li class="list-group-item flex-between">
                <p class="fw-bold mb-0">Sesi 4</p>
                <p class="mb-0">14.00 &ndash; 15.45</p>
            </li>
            <li class="list-group-item flex-between">
                <p class="fw-bold mb-0">Sesi 5</p>
                <p class="mb-0">16.00 &ndash; 17.45</p>
            </li>
        </ul>

        <div class="alert alert-primary mt-3" role="alert">
            Mohon untuk <strong>menunggu konfirmasi dari pihak perpustakaan</strong> untuk memastikan bahwa reservasi telah berhasil.
        </div>
    </div>
    <div class="col-lg-8 mb-3">
        <h5 class="fw-bold text-primary">Daftar Ruang Baca</h5>
        <!-- Display in format Bootstrap5 Carousel -->
        <div id="car-ruang-baca" class="carousel slide rounded overflow-hidden" data-bs-ride="false">
            <?php
            $sql = "SELECT * FROM ruang_baca";
            $result = mysqli_query($conn, $sql);
            // Fetch to array
            $ruang_baca = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
            <div class="carousel-indicators">
                <?php foreach ($ruang_baca as $key => $value) { ?>
                    <button type="button" data-bs-target="#car-ruang-baca" data-bs-slide-to="<?php echo $key; ?>" <?php echo ($key == 0) ? 'class="active"' : ''; ?>></button>
                <?php } ?>
            </div>
            <div class="carousel-inner">
                <?php
                foreach ($ruang_baca as $key => $row) {
                ?>
                    <div class="carousel-item <?php echo ($key == 0) ? 'active' : ''; ?>">
                        <img src="../assets/images/ruang-baca/<?php echo $row['gambar']; ?>" class="d-block w-100" style="aspect-ratio: 16 / 9; object-fit: cover">
                        <div class="carousel-caption d-none d-md-block bg-black bg-opacity-50 px-2">
                            <h5><?php echo $row["nama_ruang"]; ?></h5>
                            <p class="mb-2"><?php echo $row['deskripsi']; ?></p>
                            <p class="mb-0 small text-light">Kapasitas: <strong><?php echo $row["kapasitas"];?> orang</strong></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#car-ruang-baca" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#car-ruang-baca" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<div class="alert alert-info mt-3" role="alert">
    <p class="fw-bold mb-1">Aturan peminjaman:</p>
    <ul class="list-custom">
        <li>Toleransi keterlambatan masuk ke ruang baca adalah 15 menit, setelah itu maka ruangan akan diberikan kepada pengantri selanjutnya.</li>
        <li>Batas pengguna ruang baca adalah 150% dari kapasitas kursi. Apabila melebihi, pengguna dikenakan denda berupa pelarangan peminjaman ruang baca selama 30 hari.</li>
        <li>Pengguna ruang baca wajib mematuhi protokol kesehatan yang berlaku.</li>
        <li>Pengguna meninggalkan kartu pengenal (KTP/SIM) pada pemustaka ketika hendak mengisi ruangan baca.</li>
    </ul>
</div>

<div class="text-center mb-3">
    <a href="./ReservasiRuangPage.php" class="btn btn-dark btn-lg">
        <img src="../assets/images/mc-icons/knowledge_book.png" class="mc-icon" width="24">
        Reservasi Ruang Baca
    </a>
</div>

<div class="table-responsive" style="margin-bottom:15vw;">
    <table class="table table-hover rounded rounded-1 overflow-hidden align-middle">
        <thead class="text-nowrap text-center">
            <tr class="table-dark">
                <th scope="col">No</th>
                <th scope="col">Nama Ruangan</th>
                <th scope="col">Tanggal Reservasi</th>
                <th scope="col">Waktu Reservasi</th>
                <th scope="col">Status</th>
                <th scope="col">Edit/Hapus</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $query = "SELECT *, rev.id AS id_reservasi FROM reservasi_ruang_baca rev join ruang_baca rb on (rev.id_ruang = rb.id) WHERE rev.id_user = ?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                echo '<tr> <td colspan="7"> Tidak ada data </td> </tr>';
            } else {
                $no = 1;
                while ($data = mysqli_fetch_assoc($result)) {
                    $sudah_lewat = strtotime($data["tanggal"]) < time();
                    ?>
                    <tr class="text-center <?php if($sudah_lewat) echo 'opacity-50';?>">
                        <th scope="row"><?php echo $no; ?></th>
                        <td>
                            <img src="../assets/images/ruang-baca/<?php echo $data['gambar']; ?>" class="rounded mb-1 gambar-ruang-sm" />
                            <p class="mb-0"><?php echo $data['nama_ruang']; ?></p>
                        </td>
                        <td><?php echo date('j F Y', strtotime($data['tanggal'])); ?></td>
                        <td class="text-center"><?php echo $sesi[ $data['sesi'] ]?> </td>
                        <td class="text-center">
                        <?php
                            if ($data['status'] == 2) { ?>
                                <div class="text-bg-danger py-1 px-2 rounded">Reservasi Ditolak</div>
                            <?php } else if ($data['status'] == 1) { ?>
                                <div class="text-bg-success py-1 px-2 rounded">Reservasi Diterima</div>
                            <?php } else { ?>
                                <div class="text-bg-light py-1 px-2 rounded">Belum Diverifikasi</div>
                            <?php }
                        ?></td>
                        <td>
                        <?php if ($data['status'] === 0 && !$sudah_lewat) { ?>
                            <a href='./EditReservasiPage.php?id=<?php echo $data['id_reservasi']; ?>' class="btn btn-light">
                                <img src="../assets/images/mc-icons/netherite_pickaxe.png" class="mc-icon" width="30rem" />
                            </a>

                            <button onclick="hapusReservasi(this);" class="btn btn-light" data-json='<?php echo json_encode($data); ?>'>
                                <img src="../assets/images/mc-icons/barrier.png" class="mc-icon" width="30rem" />
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

<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin menghapus reservasi ruangan <strong id="namaRuang"></strong>?
            </div>
            <form class="modal-footer" action="../process/penghapusanReservasi.php" method="POST">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="action" value="hapus_reservasi">Hapus</button>
                <input type="hidden" name="id_reservasi" id="idReservasi" />
            </form>
        </div>
    </div>
</div>
<script>
    function hapusReservasi(element) {
        var data = JSON.parse(element.getAttribute('data-json'));
        document.getElementById('namaRuang').innerHTML = data.nama_ruang;
        document.getElementById('idReservasi').value = data.id_reservasi;

        bootstrap.Modal.getOrCreateInstance(document.getElementById("hapusModal")).show();
        // $('#pengembalianModal').modal('show');
    }
</script>