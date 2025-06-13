<?php
require '../db.php';

// Validasi input
if (!isset($_POST['id_pengaduan'], $_POST['tgl_tanggapan'], $_POST['tanggapan'], $_POST['id_petugas'])) {
    die("Data yang diperlukan tidak lengkap");
}

$id_pengaduan = $_POST['id_pengaduan'];
$tgl = $_POST['tgl_tanggapan'];
$tanggapan = $_POST['tanggapan'];
$id_petugas = $_POST['id_petugas'];
$st = 'selesai';

// Mulai transaction
mysqli_begin_transaction($db);

try {
    // Insert tanggapan
    $stmt1 = $db->prepare("INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssss", $id_pengaduan, $tgl, $tanggapan, $id_petugas);
    $stmt1->execute();
    
    // Update status
    $stmt2 = $db->prepare("UPDATE pengaduan SET status = ? WHERE id_pengaduan = ?");
    $stmt2->bind_param("ss", $st, $id_pengaduan);
    $stmt2->execute();
    
    // Commit transaction
    mysqli_commit($db);
    
    echo "<script>
            alert('Data Sudah Ditanggapi');
            window.location.href = 'petugas.php';
          </script>";
    exit;
    
} catch (Exception $e) {
    // Rollback jika ada error
    mysqli_rollback($db);
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>