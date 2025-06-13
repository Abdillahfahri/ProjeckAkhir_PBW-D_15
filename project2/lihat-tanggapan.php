<?php
include('db.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: masyarakat.php");
    exit;
}

$id = mysqli_real_escape_string($db, $_GET['id']);

$query = mysqli_query($db, "SELECT * FROM pengaduan,tanggapan WHERE tanggapan.id_pengaduan = '$id' AND tanggapan.id_pengaduan=pengaduan.id_pengaduan");
$cek = mysqli_num_rows($query);
?>

<div class="card shadow">
    <div class="card-header">
        <a href="?url=lihat-pengaduan" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="card-body">

    <?php
    if(mysqli_num_rows($query) == 0) {
        echo"<div class='alert alert-danger'>Maaf Pengaduan Anda Belum Ditanggapi.</div>";
    }else{
    if (!$query) {
        die("Query error: " . mysqli_error($db));
    }

    $data = mysqli_fetch_array($query);
    if (!$data) {
    die("Data tidak ditemukan.");
    }
    ?>

        <div class="form-group cols-sm-4">
            <label>Tanggal Tanggapan</label>
            <input type="text" name="tgl_pengaduan" class="form-control" readonly value="<?php echo $data['tgl_tanggapan']; ?>">
        </div>

        <div class="form-group cols-sm-6">
            <label>Isi Laporan</label>
            <textarea name="isi_laporan" class="form-control" rows="7" readonly=""><?php echo $data['isi_laporan']; ?></textarea>
        </div>

        <div class="form-group cols-sm-6">
            <label>Tanggapan</label>
            <textarea name="isi_laporan" class="form-control" rows="7" readonly=""><?php echo $data['tanggapan']; ?></textarea>
        </div>

    <?php } ?>
    </div>
</div>
