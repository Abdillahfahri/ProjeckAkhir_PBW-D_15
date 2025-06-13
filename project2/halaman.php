<style>
.center-text {
  text-align: center;
}
</style>

<div class="center-text">
    <?php

    if(isset($_GET['url'])){
        switch ($_GET['url']){
            case 'tulis-pengaduan':
                include 'tulis-pengaduan.php';
                break;

            case 'lihat-pengaduan':
                include 'lihat-pengaduan.php';
                break;
            
            case 'detail-pengaduan':
                include 'detail-pengaduan.php';
                break;

            case 'lihat-tanggapan':
                include 'lihat-tanggapan.php';
                break;

            case 'edit-pengaduan':
                include 'edit-pengaduan.php';
                break;

            default:
                echo "Halaman Tidak Ditemukan";
                break;
        }
    }else{
        echo "Selamat Datang.<br>";
        echo "Anda login sebagai : ".(isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Tidak Diketahui')."<br>";
        echo "NIK Anda : ".(isset($_SESSION['nik']) ? $_SESSION['nik'] : 'Tidak Diketahui');


    }
    ?>
</div>
