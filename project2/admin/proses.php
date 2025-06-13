<?php
require '../db.php';


if (!isset($_GET['id'])) {
    die("Error: Parameter ID tidak ditemukan");
}


$id = mysqli_real_escape_string($db, $_GET['id']);


$query = "UPDATE pengaduan SET status='proses' WHERE id_pengaduan='$id'";
$sql = mysqli_query($db, $query);


if ($sql) {
    header('Location: admin.php?url=verifikasi-pengaduan');
    exit;
} else {

    die("Gagal update status: " . mysqli_error($db));
}
?>