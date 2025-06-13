<div class="card shadow">
<div class="card-header">
    <a href="masyarakat.php" class="btn btn-primary btn-icon-split">
        <span class= "icon text-white-5">
            <i class="fa fa-arrow-left"></i>
        </span>
        <span class="text"> Kembali </span>
    </a>
</div>
<div class="card-body">

<form method="post" action="proses-pengaduan.php" enctype="multipart/form-data">

    <div class="form-group">
        <label>Tanggal Pengaduan</label>
        <input type="text" name="tgl_pengaduan" class="form-control" readonly value="<?= date('Y/m/d'); ?>">
    </div>

    <div class="form-group">
        <label>Isi Laporan</label>
        <textarea name="isi_laporan" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label>Foto</label>
        <input type="file" required class="form-control" name="foto" accept="image/*"></input>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success"> SIMPAN </button>
    </div>

</form>

</div>
</div>