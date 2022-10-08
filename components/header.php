<?php
session_start();
if (!($_SESSION["id"] ?? false)) {
	header("Location: ./loginPage.php");
}

require '../db.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
	<link href="../assets/css/style.css" rel="stylesheet">
	<!-- icon -->
	<link rel="icon" href="../assets/images/mc-icons/bookshelf.png">
	<title>Dashboard</title>
</head>

<body class="main-body">
	<!-- Navbar -->
	<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark nav-menu">
		<div class="nav-site-title mb-0 mb-md-3">
			<div class="d-flex d-md-block text-center justify-content-between align-items-center">
				<a href="./HomePage.php" class="btn text-white">
					<img src="../assets/images/mc-icons/bookshelf.png" alt="bookshelf" width="32" height="32" class="mc-icon me-1">
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
						<!-- <li>
						<a href="#" class="nav-link text-white">
							<img src="../assets/images/mc-icons/netherite_sword.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
							Dashboard
						</a>
					</li> -->
						<li>
							<a href="../page/HomeUser.php" class="nav-link text-white">
								<img src="../assets/images/mc-icons/written_book.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Daftar Buku
							</a>
						</li>
						<li>
							<a href="../page/DaftarPeminjamanPage.php" class="nav-link text-white">
								<img src="../assets/images/mc-icons/writable_book.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Daftar Peminjaman
							</a>
						</li>
						<li>
							<a href="../page/DaftarReservasiRuangPage.php" class="nav-link text-white">
								<img src="../assets/images/mc-icons/feather.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Daftar Reservasi
							</a>
						</li>
						<li>
							<a href="../page/ListSaranKritikPage.php" class="nav-link text-white">
								<img src="../assets/images/mc-icons/birch_sign.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Saran Kritik
							</a>
						</li>
					</ul>
				<?php } else if ($_SESSION["user"]["role"] == "admin") { ?>
					<ul class="nav nav-pills flex-column mb-auto">
						<li>
							<a href="../page/HomeAdmin.php" class="nav-link text-white">
								<img src="../assets/images/mc-icons/netherite_sword.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">

								Home Admin
							</a>
						</li>
						<a href="../page/TambahBukuPage.php" class="nav-link text-white">
							<img src="../assets/images/icon_tambah.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
							Tambah Buku
						</a>
						</li>
						<li>
							<a href="../page/CekPeminjamanPage.php" class="nav-link text-white">
								<img src="../assets/images/icon_ender.jpg" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Cek Peminjam
							</a>
						</li>
						<li>
							<a href="../page/DaftarReservasiAdminPage.php" class="nav-link text-white">
								<img src="../assets/images/mc-icons/writable_book.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Daftar Reservasi
							</a>
						</li>
						<li>
							<a href="../page/SaranKritikAdminPage.php" class="nav-link text-white">
								<img src="../assets/images/mc-icons/birch_sign.png" class="nav-icons mc-icon" style="margin-right:0.5rem;">
								Cek Kritik/Saran
							</a>
						</li>
					</ul>
				<?php } ?>
			</div>
			<div class="dropdown navw-bottom mt-3 mt-md-0">
				<hr />
				<a href="javascript:void(0)" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="<?php echo $_SESSION["user"]["foto"] != null ? "../uploads/" . $_SESSION["user"]["foto"] : "../assets/images/icon_user.png"; ?>" alt="" width="36" height="36" class="rounded-circle me-2">
					<div style="width: calc(100% - 58px)">
						<div class="text-truncate"><?php echo $_SESSION["user"]["nama"]; ?></div>
						<div class='text-muted small'>
							<?php echo $_SESSION["user"]["role"] == "user" ? "Peminjam" : "Admin"; ?>
						</div>
					</div>
				</a>
				<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="../page/EditProfil.php">Edit Profile</a></li>
					<li><a class="dropdown-item" href="../page/ShowProfil.php">View Profile</a></li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li><a class="dropdown-item text-bg-danger" href="../process/logoutProfil.php">Sign out</a></li>
				</ul>
			</div>
		</nav>
	</div>

	<style>
		.main-body {
			display: flex;
			flex-flow: row;
		}

		.main-content {
			flex: 1;
			padding: 1.25rem;
			width: calc(100% - var(--jc-sidebar-width));
		}

		.nav-icons {
			display: inline-block;
			width: 1.5rem;
		}

		.nav-item {
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
			flex-shrink: 0;
		}

		.nav-menu {
			height: 100vh;
			flex-shrink: 0;
			width: var(--jc-sidebar-width);
			position: sticky;
			top: 0;
			z-index: 1000;
		}

		.nav-menu .nav-area {
			margin-left: -1rem;
			margin-right: -1rem;
			padding-left: 1rem;
			padding-right: 1rem;
			/* height: 100%; */
			overflow: auto;
			flex-wrap: nowrap;
		}

		.nav-menu .nav-link {
			display: flex;
			align-items: center;
			justify-content: flex-start;
			transition: 0s;
		}

		.nav-menu .nav-link:hover {
			background-color: rgba(0, 0, 0, 0.5);
		}

		.nav-menu .nav-link.active:hover {
			background-color: var(--bs-link-hover-color);
		}

		#nav-wrapper {
			width: 100%;
			flex-flow: column;
			justify-content: space-between;
			align-items: stretch;
		}

		@media screen and (min-width: 768px) {
			#nav-wrapper {
				height: 100%;
			}
		}

		@media screen and (max-width: 767.98px) {
			.main-body {
				flex-flow: column;
			}

			.main-content {
				width: 100%;
			}

			.nav-menu {
				width: 100%;
				height: auto;
			}

			.nav-area {
				margin-top: 1rem;
			}

			.nav-site-title::after {
				content: none;
			}
		}
	</style>
	<main class="main-content">