<?php include '../components/header.php';

$cek = $_SESSION["user"];
?>

<div class="d-flex justify-content-between">
	<h4 class="mb-0">Edit Akun</h4>
	<a class="btn btn-success" href="javascript:history.back()">Kembali</a>
</div>

<img src="../assets/images/mc-villager.png" class="villager"/>
<hr>

<form action="../process/editUser.php" method="POST" enctype="multipart/form-data" style="max-width: 600px">
	<div class="mb-3">
		<label for="nama" class="form-label">Nama Lengkap</label>
		<input type="text" class="form-control" id="nama" name="nama" required value="<?php echo $cek['nama'] ?>">
	</div>

	<div class="mb-3">
		<label for="email" class="form-label">Email</label>
		<input type="text" class="form-control" id="email" name="email" required value="<?php echo $cek['email'] ?>" <?php if ($cek['role'] == "admin") echo 'disabled'; ?>>
	</div>

	<div class="mb-3">
		<label for="password" class="form-label mb-0">Password</label>
		<div class="small text-muted mb-2">Kosongkan jika tidak ingin diubah</div>
		<input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin diubah">
	</div>
	<div class="mb-3">
		<label for="formFileSm" class="form-label mb-0">Ganti Foto Pengguna</label>
		<div class="small text-muted mb-2">Kosongkan jika tidak ingin diubah</div>
		<input class="form-control" id="formFileSm" type="file" name="foto" accept=".jpg, .jpeg, .png">
	</div>
	<div class="d-grid gap-2">
		<button type="submit" class="btn btn-primary" name="action" value="edit_user">Update</button>
	</div>
</form>




<?php include '../components/footer.php'; ?>