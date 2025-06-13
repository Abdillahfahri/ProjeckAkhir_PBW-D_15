<?php
session_start();
if (!isset($_SESSION["nik"])) {
  echo "<script>alert('Maaf, anda belum login.'); window.location.assign('index.php');</script>";
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Aplikasi Laporan Masyarakat</title>


  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">


  <div id="wrapper">


    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


      <a class="sidebar-brand d-flex align-items-center justify-content-center text-gray-100">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">LAPORR</div>
      </a>


      <hr class="sidebar-divider my-0">


      <li class="nav-item">
        <a class="nav-link" href="masyarakat.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>


      <hr class="sidebar-divider">


      <div class="sidebar-heading">
        Interface
      </div>



      <li class="nav-item">
        <a class="nav-link" href="?url=tulis-pengaduan">
          <i class="fas fa-fw fa-edit"></i>
          <span>Tulis Pengaduan</span></a>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="?url=lihat-pengaduan">
          <i class="fas fa-fw fa-table"></i>
          <span>Lihat Pengaduan</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">


      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>



    <div id="content-wrapper" class="d-flex flex-column">


      <div id="content">


          <style>
            .navbar h1 {
              font-size: clamp(1.2rem, 3vw, 1.8rem);
              margin: 0;
              white-space: nowrap;
              overflow: hidden;
              text-overflow: ellipsis;
              flex-grow: 1;
              text-align: center;
              padding-left: 15px;
            }
            
            @media (max-width: 576px) {
              .navbar h1 {
                padding-left: 10px;
                font-size: 1.1rem;
              }
            }
          </style>

          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>
            <h1>Pengaduan Masyarakat</h1>
          </nav>



        <div class="container-fluid">


          <h1 class="h4 mb-4 text-gray-800 text-center"><?php include 'halaman.php'; ?></h1>

        </div>


      </div>



      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Aplikasi Pengaduan Masyarakat&copy2025</span>
          </div>
        </div>
      </footer>


    </div>


  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
