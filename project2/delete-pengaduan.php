<?php
// delete_pengaduan.php

session_start();
require 'db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['nik'])) {
    header("Location: ../index.php");
    exit;
}

// Cek apakah request menggunakan method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: lihat-pengaduan.php?error=invalid_method");
    exit;
}

// Validasi input
if (!isset($_POST['id_pengaduan'])) {
    header("Location: lihat-pengaduan.php?error=missing_id");
    exit;
}

$id_pengaduan = mysqli_real_escape_string($db, $_POST['id_pengaduan']);

// Verifikasi kepemilikan pengaduan
$query = mysqli_query($db, "SELECT * FROM pengaduan WHERE id_pengaduan='$id_pengaduan' AND nik='$_SESSION[nik]'");
if (mysqli_num_rows($query) === 0) {
    header("Location: lihat-pengaduan.php?error=not_owner");
    exit;
}

// Dapatkan data foto sebelum dihapus
$data = mysqli_fetch_assoc($query);

// Hapus file foto jika ada
if (!empty($data['foto']) && file_exists("foto/".$data['foto'])) {
    unlink("foto/".$data['foto']);
}

// Hapus dari database
$delete = mysqli_query($db, "DELETE FROM pengaduan WHERE id_pengaduan='$id_pengaduan'");

if ($delete) {
    header("Location: masyarakat.php?url=lihat-pengaduan");
} else {
    header("Location: masyarakat.php?url=lihat-pengaduan");
}
exit;
?>