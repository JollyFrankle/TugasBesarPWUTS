<?php
session_start();
if($_SESSION["id"] ?? false){
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
    <link href="../style.css" rel="stylesheet">
    <title>Dashboard</title>
</head>

<body class="main-body">
    <!-- Navbar -->
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark nav-menu">
        <div class="nav-site-title">
            <div class="d-flex justify-content-between align-items-center">
                <span>
                    <img src="../assets/images/mc-icons/bookshelf.png" alt="bookshelf" width="32" height="32" class="mc-icon">
                    <strong>Minecraft</strong> Library</span>
                <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav-wrapper" aria-controls="nav-wrapper" aria-expanded="true" aria-label="Toggle navigation">
                    <i class="bi bi-menu-button"></i>
                </button>
            </div>
        </div>
        <nav class="d-md-flex collapse" id="nav-wrapper">
            <div class="nav-area">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <a href="#" class="nav-link text-white">
                            <i class="nav-icons bi bi-speedometer"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <i class="nav-icons bi bi-table"></i>
                            Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="./list-produk.php" class="nav-link text-white" data-url-prefix="/list-produk.php">
                            <i class="nav-icons bi bi-grid"></i>
                            Produk/Barang
                        </a>
                    </li>
                    <li>
                        <a href="./list-transaksi.php" class="nav-link text-white" data-url-prefix="/list-transaksi.php">
                            <i class="nav-icons bi bi-box-seam"></i>
                            Penjualan
                        </a>
                    </li>
                    <li>
                        <a href="./list-pelanggan.php" class="nav-link text-white">
                            <i class="nav-icons bi bi-people"></i>
                            Pelanggan
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <i class="nav-icons bi bi-bookmarks"></i>
                            Laporan
                        </a>
                    </li>
                </ul>
            </div>
            <!-- <div class="dropdown navw-bottom">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div> -->
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