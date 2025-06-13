<?php
session_start();

$tgl_pengaduan = $_POST['tgl_pengaduan'];
$nik = $_SESSION['nik'];
$isi_laporan = $_POST['isi_laporan'];
$lokasi_foto = $_FILES['foto']['tmp_name'];
$nama_foto = $_FILES['foto']['name'];
$status = 0;

if (move_uploaded_file($lokasi_foto, 'foto/' . $nama_foto)) {
    include 'db.php';
    $sql = "INSERT INTO pengaduan(tgl_pengaduan, nik, isi_laporan, foto, status) 
            VALUES('$tgl_pengaduan', '$nik', '$isi_laporan', '$nama_foto', '$status')";

    if (mysqli_query($db, $sql)) {
        echo "<script>alert('Pengaduan Sudah Dikirim');
        window.location.assign('masyarakat.php'); </script>";
    } else {
        echo "<script>alert('Pengaduan Gagal Dikirim');
        window.location.assign('masyarakat.php?url=tulis-pengaduan'); </script>";
    }
} else {
    echo "<script>alert('Upload foto gagal');
    window.location.assign('masyarakat.php?url=tulis-pengaduan'); </script>";
}
