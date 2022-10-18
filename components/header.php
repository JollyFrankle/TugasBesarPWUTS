<?php
session_start();
if (!($_SESSION["id"] ?? false)) {
	header("Location: ../Login.php");
}

require __DIR__.'/../db.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
	<link href="../../assets/css/style.css" rel="stylesheet">
	<link href="../../assets/css/header.css" rel="stylesheet">
	<!-- icon -->
	<link rel="icon" href="../../assets/images/mc-icons/bookshelf.png">
	<title>Minecraft Library</title>
</head>

<body class="main-body">
	<!-- Navbar -->
	<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark nav-menu">
		<div class="nav-site-title mb-0 mb-md-3">
			<div class="d-flex d-md-block text-center justify-content-between align-items-center">
				<a href="../../page/Home.php" class="btn text-white">
					<img src="../../assets/images/mc-icons/bookshelf.png" alt="bookshelf" width="32" height="32" class="mc-icon me-1">
					<strong>Minecraft</strong> Library
				</a>
				<button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav-wrapper" aria-controls="nav-wrapper" aria-expanded="true" aria-label="Toggle navigation">
					<i class="fas fa-bars"></i>
				</button>
			</div>
		</div>
		<nav class="d-md-flex collapse" id="nav-wrapper">
			<div class="nav-area">
				<?php if ($_SESSION["user"]["role"] == "user") { ?>
					<ul class="nav nav-pills flex-column mb-auto">
						<li>
							<a href="../User/Home.php" class="nav-link text-white">
								<img src="../../assets/images/mc-icons/written_book.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Daftar Buku
							</a>
						</li>
						<li>
							<a href="../User/ListPeminjaman.php" class="nav-link text-white">
								<img src="../../assets/images/mc-icons/writable_book.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Daftar Peminjaman
							</a>
						</li>
						<li>
							<a href="../User/ListReservasi.php" class="nav-link text-white">
								<img src="../../assets/images/mc-icons/feather.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Daftar Reservasi
							</a>
						</li>
						<li>
							<a href="../User/ListKritikSaran.php" class="nav-link text-white">
								<img src="../../assets/images/mc-icons/birch_sign.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Saran Kritik
							</a>
						</li>
					</ul>
				<?php } else if ($_SESSION["user"]["role"] == "admin") { ?>
					<ul class="nav nav-pills flex-column mb-auto">
						<li>
							<a href="../Admin/Home.php" class="nav-link text-white">
								<img src="../../assets/images/mc-icons/netherite_sword.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">

								Home Admin
							</a>
						</li>
						<a href="../Admin/TambahBuku.php" class="nav-link text-white">
							<img src="../../assets/images/icon_tambah.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
							Tambah Buku
						</a>
						</li>
						<li>
							<a href="../Admin/CekPeminjaman.php" class="nav-link text-white">
								<img src="../../assets/images/icon_ender.jpg" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Cek Peminjam
							</a>
						</li>
						<li>
							<a href="../Admin/ListReservasi.php" class="nav-link text-white">
								<img src="../../assets/images/mc-icons/writable_book.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Daftar Reservasi
							</a>
						</li>
						<li>
							<a href="../Admin/ListKritikSaran.php" class="nav-link text-white">
								<img src="../../assets/images/mc-icons/birch_sign.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Cek Kritik/Saran
							</a>
						</li>
					</ul>
				<?php } ?>
			</div>
			<div class="dropdown navw-bottom mt-3 mt-md-0">
				<hr />
				<a href="javascript:void(0)" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="<?php echo $_SESSION["user"]["foto"] != null ? "../../uploads/" . $_SESSION["user"]["foto"] : "../../assets/images/icon_user.png"; ?>" alt="" width="36" height="36" class="rounded-circle me-2">
					<div style="width: calc(100% - 58px)">
						<div class="text-truncate"><?php echo $_SESSION["user"]["nama"]; ?></div>
						<div class='text-muted small'>
							<?php echo $_SESSION["user"]["role"] == "user" ? "Peminjam" : "Administrator"; ?>
						</div>
					</div>
				</a>
				<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../Profile/Edit.php">Edit Profile</a></li>
					<li><a class="dropdown-item" href="../Profile/View.php">View Profile</a></li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li><a class="dropdown-item text-bg-danger" href="../../process/logoutProfil.php">Sign out</a></li>
				</ul>
			</div>
		</nav>
	</div>
	<main class="main-content">