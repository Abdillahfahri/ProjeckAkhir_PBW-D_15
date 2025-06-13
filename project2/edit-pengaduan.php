<?php
session_start();
require 'db.php';


if (!isset($_SESSION['nik']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}


$id = mysqli_real_escape_string($db, $_GET['id']);
$query = mysqli_query($db, "SELECT * FROM pengaduan WHERE id_pengaduan='$id' AND nik='$_SESSION[nik]'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan atau tidak memiliki akses");
}


if ($data['status'] != '0') {
    die("<script>alert('Pengaduan yang sudah diproses tidak dapat diedit'); window.location.href='data_pengaduan.php';</script>");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isi_laporan = mysqli_real_escape_string($db, $_POST['isi_laporan']);
    

    $foto = $data['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $file_name = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_ext, $allowed_ext)) {

            if (!empty($foto) && file_exists("foto/$foto")) {
                unlink("foto/$foto");
            }
            

            $foto = "pengaduan_".time().".$file_ext";
            move_uploaded_file($file_tmp, "foto/$foto");
        } else {
            die("<script>alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG'); window.history.back();</script>");
        }
    }
    
    $update = mysqli_query($db, "UPDATE pengaduan SET 
                                isi_laporan='$isi_laporan', 
                                foto='$foto' 
                                WHERE id_pengaduan='$id'");
    
    if ($update) {
        header("Location: masyarakat.php?url=lihat-pengaduan");
        exit;
    } else {
        die("Gagal update: " . mysqli_error($db));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pengaduan</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="fas fa-edit mr-2"></i>Edit Pengaduan</h5>
          </div>
          <div class="card-body">
            <form method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label>Isi Laporan</label>
                <textarea name="isi_laporan" class="form-control" rows="5" required><?= htmlspecialchars($data['isi_laporan']) ?></textarea>
              </div>
              
              <div class="form-group">
                <label>Foto Saat Ini</label>
                <div class="mb-3">
                  <?php if (!empty($data['foto'])): ?>
                    <img src="foto/<?= $data['foto'] ?>" class="img-thumbnail" width="200">
                    <div class="mt-2">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="hapus_foto" id="hapus_foto">
                        <label class="form-check-label text-danger" for="hapus_foto">
                          <i class="fas fa-trash-alt mr-1"></i> Hapus foto ini
                        </label>
                      </div>
                    </div>
                  <?php else: ?>
                    <p class="text-muted">Tidak ada foto</p>
                  <?php endif; ?>
                </div>
                
                <label>Ubah Foto (opsional)</label>
                <div class="custom-file mb-3">
                  <input type="file" name="foto" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Pilih file...</label>
                  <small class="form-text text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                </div>
              </div>
              
              <div class="form-group">
                <button type="submit" class="btn btn-primary mr-2">
                  <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
                <a href="masyarakat.php?url=lihat-pengaduan" class="btn btn-secondary">
                  <i class="fas fa-times mr-1"></i> Batal
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  
  <!-- Script untuk update nama file -->
  <script>
    $('.custom-file-input').on('change', function() {
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
  </script>
</body>
</html>