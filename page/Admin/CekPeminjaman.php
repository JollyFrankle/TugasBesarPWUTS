<?php include '../../components/header.php'; ?>
<div class="body d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Cek Peminjam Per Buku</h4>
    <img src="../../assets/images/mc-villager.png" class="villager"/>
</div>

<hr>
<div class="table-responsive" style="margin-bottom:15vw;">
    <table class="table table-hover rounded rounded-1 overflow-hidden">
        <thead class="text-nowrap">
            <tr class="table-dark">
                <th scope="col">No</th>
                <th scope="col">Nama Buku</th>
                <th scope="col" class="text-center">Gambar</th>
                <th scope="col" class="text-center">Jumlah Terpinjam</th>
                <th scope="col" class="text-center">Cek Peminjam</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $query = mysqli_query($conn, "SELECT B.*, (SELECT COUNT(P.id) FROM peminjaman P WHERE P.id_buku = B.id AND P.status = 1) AS jumlah_terpinjam FROM buku B;") or die(mysqli_error($conn));
            if (mysqli_num_rows($query) == 0) {
                echo '<tr> <td colspan="4"> Tidak ada data </td> </tr>';
            } else {
                $no = 1;
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr class="align-middle">
                        <th scope="row" class="text-center"><?php echo $no; ?></th>
                        <td><?php echo $data['judul']; ?></td>
                        <td class="text-center">
                            <img src="../../uploads/<?php echo $data['gambar']; ?>" class="gambar-buku-sm"/>
                        </td>
                        <td class="text-center"><?php echo $data['jumlah_terpinjam']; ?></td>
                        <td class="text-center">
                            <a href='./PreviewUser.php?id=<?php echo $data['id']; ?>' class="btn btn-light">
                                <img src="../../assets/images/mc-icons/ender_eye.png" class="mc-icon" width="30rem" />
                            </a>
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