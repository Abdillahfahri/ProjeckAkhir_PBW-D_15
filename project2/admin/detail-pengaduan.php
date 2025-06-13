<?php
require('../db.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = mysqli_real_escape_string($db, $_GET['id']); // Melindungi dari SQL injection

$query = mysqli_query($db, "SELECT * FROM pengaduan WHERE id_pengaduan = '$_GET[id]'");
if (!$query) {
    die("Query error: " . mysqli_error($db));
}

$data = mysqli_fetch_array($query);
if (!$data) {
    die("Data tidak ditemukan.");
}
?>

<div class="card shadow">
    <div class="card-header">
        <a href="admin.php" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>

        <a href="proses.php?id=<?php echo $data['id_pengaduan']; ?>" class="btn btn-danger btn-icon-split" onclick="return confirm('Yakin akan di diproses?')">
            <span class="icon text-white-50">
                <i class="fa fa-check"></i>
            </span>
            <span class="text">Proses Verifikasi</span>
        </a>
    </div>

    <div class="card-body">
        <form method="post" action="proses-pengaduan.php" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tanggal Pengaduan</label>
                <input type="text" name="tgl_pengaduan" class="form-control" readonly value="<?= htmlspecialchars($data['tgl_pengaduan']) ?>">
            </div>

            <div class="form-group">
                <label>Isi Laporan</label>
                <textarea name="isi_laporan" class="form-control" readonly><?= htmlspecialchars($data['isi_laporan']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Foto</label><br>
                <img class="img-thumbnail" src="../foto/<?= htmlspecialchars($data['foto']) ?>" width="300">
            </div>

        </form>
    </div>
</div>
