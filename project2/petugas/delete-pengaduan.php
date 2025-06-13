<?php
include('../db.php');
session_start();

// Cek level admin/petugas
if ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'petugas') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($db, $_GET['id']);
    
    // 1. Ambil informasi foto sebelum menghapus
    $query = mysqli_query($db, "SELECT foto FROM pengaduan WHERE id_pengaduan='$id'");
    $data = mysqli_fetch_assoc($query);
    
    // 2. Hapus file foto jika ada
    if (!empty($data['foto'])) {
        $file_path = '../foto/' . $data['foto'];
        if (file_exists($file_path)) {
            unlink($file_path); // Hapus file dari direktori
        }
    }
    
    // 3. Hapus dari database
    $delete_query = mysqli_query($db, "DELETE FROM pengaduan WHERE id_pengaduan='$id'");
    
    if ($delete_query) {
        $_SESSION['success'] = "Pengaduan berhasil dihapus";
    } else {
        $_SESSION['error'] = "Gagal menghapus pengaduan: " . mysqli_error($db);
    }
    
    header("Location: petugas.php?url=lihat-pengaduan");
    exit;
} else {
    header("Location: petugas.php?url=lihat-pengaduan");
    exit;
}
?>