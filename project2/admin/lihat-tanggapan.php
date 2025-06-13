<?php
include('../db.php');

// Verifikasi session dan level admin
if (!isset($_SESSION['level']) || $_SESSION['level'] != "admin") {
    echo "<script>alert('Akses ditolak.'); window.location.assign('index2.php');</script>";
    exit;
}

// Validasi parameter ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ?url=lihat-pengaduan");
    exit;
}

$id = mysqli_real_escape_string($db, $_GET['id']);

// Query yang lebih aman dengan JOIN dan prepared statement
$query = mysqli_query($db, "SELECT p.*, t.*, m.nama, pt.nama_petugas 
                           FROM pengaduan p
                           LEFT JOIN tanggapan t ON t.id_pengaduan = p.id_pengaduan
                           LEFT JOIN masyarakat m ON p.nik = m.nik
                           LEFT JOIN petugas pt ON t.id_petugas = pt.id_petugas
                           WHERE p.id_pengaduan = '$id'");
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="?url=lihat-pengaduan" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Kembali</span>
            </a>
        </div>

        <div class="card-body">
            <?php
            if (mysqli_num_rows($query) == 0) {
                echo "<div class='alert alert-warning'>Belum ada tanggapan untuk pengaduan ini.</div>";
                
                // Tampilkan data pengaduan meski belum ada tanggapan
                $query_pengaduan = mysqli_query($db, "SELECT p.*, m.nama 
                                                     FROM pengaduan p
                                                     JOIN masyarakat m ON p.nik = m.nik
                                                     WHERE p.id_pengaduan = '$id'");
                $data_pengaduan = mysqli_fetch_array($query_pengaduan);
            ?>
                <div class="form-group">
                    <label>Nama Pelapor</label>
                    <input type="text" class="form-control" readonly value="<?= htmlspecialchars($data_pengaduan['nama']) ?>">
                </div>
                
                <div class="form-group">
                    <label>Tanggal Pengaduan</label>
                    <input type="text" class="form-control" readonly value="<?= $data_pengaduan['tgl_pengaduan'] ?>">
                </div>
                
                <div class="form-group">
                    <label>Isi Laporan</label>
                    <textarea class="form-control" rows="5" readonly><?= htmlspecialchars($data_pengaduan['isi_laporan']) ?></textarea>
                </div>
                
                <?php if (!empty($data_pengaduan['foto'])): ?>
                <div class="form-group">
                    <label>Foto Bukti</label><br>
                    <img src="../foto/<?= $data_pengaduan['foto'] ?>" class="img-thumbnail" style="max-height: 300px;">
                </div>
                <?php endif; ?>
                
            <?php } else { 
                $data = mysqli_fetch_array($query);
            ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Pelapor</label>
                            <input type="text" class="form-control" readonly value="<?= htmlspecialchars($data['nama']) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Petugas Menanggapi</label>
                            <input type="text" class="form-control" readonly value="<?= htmlspecialchars($data['nama_petugas']) ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Pengaduan</label>
                            <input type="text" class="form-control" readonly value="<?= $data['tgl_pengaduan'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Tanggapan</label>
                            <input type="text" class="form-control" readonly value="<?= $data['tgl_tanggapan'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Isi Laporan</label>
                    <textarea class="form-control" rows="5" readonly><?= htmlspecialchars($data['isi_laporan']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Tanggapan</label>
                    <textarea class="form-control" rows="5" readonly><?= htmlspecialchars($data['tanggapan']) ?></textarea>
                </div>
                
                <?php if (!empty($data['foto'])): ?>
                <div class="form-group">
                    <label>Foto Bukti</label><br>
                    <img src="../foto/<?= $data['foto'] ?>" class="img-thumbnail" style="max-height: 300px;">
                </div>
                <?php endif; ?>
                
            <?php } ?>
        </div>
    </div>
</div>