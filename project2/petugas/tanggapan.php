<?php
// Tidak perlu session_start() lagi karena sudah dimulai di petugas.php
require('../db.php');

// Validasi parameter ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: petugas.php");
    exit;
}

// Pastikan level petugas sudah divalidasi di petugas.php
if (!isset($_SESSION['id_petugas'])) {
    die("Akses ditolak. Silakan login kembali.");
}

$id = mysqli_real_escape_string($db, $_GET['id']);

// Query data pengaduan
$query = mysqli_query($db, "SELECT * FROM pengaduan WHERE id_pengaduan = '$id'");
if (!$query) {
    die("Query error: " . mysqli_error($db));
}

$data = mysqli_fetch_assoc($query);
if (!$data) {
    die("Data pengaduan tidak ditemukan.");
}

?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Tanggapan</h6>
        <div>
            <a href="?url=verifikasi-pengaduan" class="btn btn-primary btn-icon-split mr-2">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Kembali</span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="simpan-tanggapan.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
                <label>Id Pengaduan</label>
                <input type="text" name="id_pengaduan" class="form-control" readonly value="<?php echo htmlspecialchars($data['id_pengaduan']); ?>">
            </div>
            
            <div class="form-group">
                <label>Tanggal Tanggapan</label>
                <input type="text" name="tgl_tanggapan" class="form-control" readonly value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label>Tulis Tanggapan</label>
                <textarea name="tanggapan" class="form-control" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label>ID Petugas</label>
                <input type="text" name="id_petugas" class="form-control" 
                       value="<?php echo htmlspecialchars($_SESSION['id_petugas']); ?>" readonly>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text">Simpan Tanggapan</span>
                </button>
            </div>
        </form>
    </div>
</div>