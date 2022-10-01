<?php include '../components/header.php';
    if(isset($_GET['id'])){
        include('../db.php');
        $id = intval($_GET['id']);
        $query = "SELECT b.*, (SELECT COUNT(id) FROM peminjaman p WHERE p.id_buku = b.id AND status = 1) AS jlh_dipinjam FROM buku b WHERE b.id = ?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $buku = $result->fetch_assoc();
    }

?>
<div class="body d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Peminjam Berdasarkan Buku</h4>
    <a href="./CekPeminjamanPage.php" class="btn btn-success">Kembali</a>
</div>
<img src="../assets/images/mc-villager.png"class="villager"/>

<hr>
<div class="row align-items-center text-center text-md-start"> 
    <div class="col-xl-3 col-lg-4 mb-4 col-md-6 justify-content-center align-items-center" style="text-align:center;">
        <img id="frame" src="../uploads/<?php echo @$buku['gambar']?>" class="gambar-buku">
    </div>
    <div class="col-xl-9 col-lg-6 col-md-6 mb-4">
        <h4 class="text-success"> <?php echo @$buku['judul']?></h4>
        <p class="mb-0"> Jumlah Buku Tersedia: <strong><?php echo @$buku['jumlah']?></strong></p>
        <p class="mb-0"> Jumlah Buku Sedang Dipinjam: <strong><?php echo @$buku['jlh_dipinjam']?></strong></p>
    </div>
</div>

<div class="row table-responsive">
    <table class="table table-hover rounded rounded-1 overflow-hidden">
        <thead class="text-nowrap">
            <tr class="table-dark">
                <th scope="col">No</th>
                <th scope="col">Nama Peminjam</th>
                <th scope="col" style="text-align:center">Tanggal Pinjam</th>
                <th scope="col" style="text-align:center">Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM peminjaman p join buku b on (p.id_buku = b.id) join users u on (p.id_user = u.id) where p.status = 1  and p.id_buku = ". $_GET["id"]) or
                die(mysqli_error($conn));
            if (mysqli_num_rows($query) == 0) {
                echo '<tr> <td colspan="7"> Tidak ada data </td> </tr>';
            } else {
                $no = 1;
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <th scope="row"><?php echo $no; ?></th>
                        <td><?php echo $data['nama']; ?></td>
                        <td style="text-align:center"><?php echo date('j F Y', strtotime($data['tanggal_pinjam'])); ?></td>
                        <td style="text-align:center"><?php echo date('j F Y', strtotime($data['tanggal_kembali'])); ?></td>
                        <!-- <td style="text-align:center"></td>? -->
                    </tr>
            <?php $no++;
                }
            }
            ?>
        </tbody>
    </table>
    </div>

<?php include '../components/footer.php'; ?>