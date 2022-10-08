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
<div class="body d-flex justify-content-between">
    <h4 class="mb-0">Daftar Reservasi Ruang Baca</h4>
    <img src="../assets/images/mc-villager.png" class="villager" />
</div>
<hr>

<div class="table-responsive" style="margin-bottom:15vw;">
    <table class="table table-hover rounded rounded-1 overflow-hidden align-middle">
        <thead class="text-nowrap">
            <tr class="table-dark">
                <th scope="col" class="text-center">No</th>
                <th scope="col">Nama Ruangan</th>
                <th scope="col">Nama Peminjam</th>
                <th scope="col" class="text-center">Tanggal Reservasi</th>
                <th scope="col" class="text-center">Waktu Reservasi</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="text-center">Konfirmasi</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $query = mysqli_query($conn, "SELECT *, rev.id AS id_reservasi FROM reservasi_ruang_baca rev join ruang_baca rb on (rev.id_ruang = rb.id) join users u on (rev.id_user = u.id) ORDER BY tanggal ASC, sesi ASC, id_ruang ASC;") or die(mysqli_error($conn));
            if (mysqli_num_rows($query) == 0) {
                echo '<tr> <td colspan="7"> Tidak ada data </td> </tr>';
            } else {
                $no = 1;
                while ($data = mysqli_fetch_assoc($query)) {
                    $sudah_lewat = strtotime($data["tanggal"]) < time();
                    ?>
                    <tr class="text-center <?php if($sudah_lewat) echo 'opacity-50';?>" >
                        <th scope="row" style="text-align:center;"><?php echo $no; ?></th>
                        <td>
                            <img src="../assets/images/ruang-baca/<?php echo $data['gambar']; ?>" class="rounded mb-1 gambar-ruang-sm" />
                            <p class="mb-0"><?php echo $data['nama_ruang']; ?></p>
                        </td>
                        <td style="text-align:left;"><?php echo $data['nama']; ?></td>
                        <td class="text-center"><?php echo date('j F Y', strtotime($data['tanggal'])); ?></td>
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
                        <td class="text-center">
                        <?php if(!$sudah_lewat) { ?>
                            <button onclick="tindakanReservasi(this);" class="btn btn-light" data-json='<?php echo json_encode($data); ?>'>
                                <img src="../assets/images/icon_action.webp" class="mc-icon" width="40rem" />
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

<div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tolakModalLabel">Konfirmasi Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tentukan status reservasi untuk reservasi berikut:</p>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Nama Pemesan</td>
                            <td id="namaReservan" class="fw-bold">...</td>
                        </tr>
                        <tr>
                            <td>Tanggal Reservasi</td>
                            <td id="tanggalReservasi" class="fw-bold">...</td>
                        </tr>
                        <tr>
                            <td>Waktu Reservasi</td>
                            <td id="waktuReservasi" class="fw-bold">...</td>
                        </tr>
                        <tr>
                            <td>Nama Ruangan</td>
                            <td id="namaRuangan" class="fw-bold">...</td>
                        </tr>
                    </tbody>
                </table>
                Tentukan pilihan:
            </div>
            <form class="modal-footer justify-content-center" action="../process/reservasiRuangAdmin.php" method="POST">
                <button type="submit" class="btn btn-success" name="action" value="terima_res">  <img src="../assets/images/icon_acc.png" class="mc-icon" height="20rem" /> Terima</button>
                <button type="submit" class="btn btn-danger" name="action" value="tolak_res">  <img src="../assets/images/icon_dcl.png" class="mc-icon" height="20rem" /> Tolak</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <input type="hidden" name="id" id="idReservasi" value="" />
            </form>
        </div>
    </div>
</div>
<script>
    function tindakanReservasi(element) {
        var data = JSON.parse(element.getAttribute('data-json'));
        document.getElementById('namaReservan').innerHTML = data.nama;
        document.getElementById('tanggalReservasi').innerHTML = new Date(data.tanggal).toDateString();
        document.getElementById('waktuReservasi').innerHTML = data.sesi;
        document.getElementById('namaRuangan').innerHTML = data.nama_ruang;
        document.getElementById('idReservasi').value = data.id_reservasi;

        bootstrap.Modal.getOrCreateInstance(document.getElementById("tolakModal")).show();
        // $('#pengembalianModal').modal('show');
    }
</script>