<?php
// session_start();
if ($_SESSION['level'] != "admin") {
    echo "<script>alert('Maaf, anda bukan admin.'); window.location.assign('index2.php');</script>";
    exit;
}

require '../db.php'; // Pastikan file ini berisi koneksi database

// Kode untuk menampilkan jumlah pengaduan
$sql = mysqli_query($db, "SELECT * FROM pengaduan WHERE status='0'");
$cek = mysqli_num_rows($sql);
?>

<style>
.center-text {
    text-align: center;
}
</style>

<div class="center-text">
    <?php
    if(isset($_GET['url'])) {
        switch ($_GET['url']) {
            case 'detail-pengaduan':
                include 'detail-pengaduan.php';
                break;
            case 'verifikasi-pengaduan':
                include 'verifikasi-pengaduan.php';
                break;
            case 'lihat-pengaduan':
                include 'lihat-pengaduan.php';
                break;
            case 'lihat-tanggapan':
                include 'lihat-tanggapan.php';
                break;
            default:
                echo "Halaman Tidak Ditemukan";
                break;
        }
    } else {
        echo "Selamat Datang.<br>";
        echo "Anda login sebagai Admin: ".(isset($_SESSION['nama_petugas']) ? $_SESSION['nama_petugas'] : 'Tidak Diketahui')."<br>";
        
        if ($cek > 0) {
    ?>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Laporan Pengaduan :</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Ada <?php echo $cek; ?> Laporan dari masyarakat</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-4x text-gray-300"></i>
                                <span class="badge badge-danger badge-counter"><?php echo $cek; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php    
        }
    }
    ?>
</div>