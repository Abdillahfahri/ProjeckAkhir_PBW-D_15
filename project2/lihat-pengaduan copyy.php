<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('db.php');


if (!isset($_SESSION['nik'])) {
  echo "Akses ditolak. Silakan login terlebih dahulu.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Pengaduan</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Pengaduan</h6>
    </div>
    <div class="card-body" style="font-size: 14px">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Tgl Pengaduan</th>
              <th>NIK</th>
              <th>Isi Laporan</th>
              <th>Foto</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM pengaduan WHERE nik='$_SESSION[nik]' ORDER BY id_pengaduan DESC";
            $query = mysqli_query($db, $sql);
            $no = 1;

            while ($data = mysqli_fetch_array($query)) {
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($data['tgl_pengaduan']); ?></td>
                <td><?= htmlspecialchars($data['nik']); ?></td>
                <td><?= htmlspecialchars($data['isi_laporan']); ?></td>
                <td>
                  <?php if (!empty($data['foto'])): ?>
                    <img src="foto/<?= htmlspecialchars($data['foto']); ?>" width="100">
                  <?php else: ?>
                    Tidak ada foto
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($data['status']); ?></td>
                <td>
                  <a href="?url=detail-pengaduan&id=<?php echo $data['id_pengaduan']; ?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-info-circle"></i> Detail
                  </a>
                  <a href="?url=lihat-tanggapan&id=<?php echo $data['id_pengaduan']; ?>" class="btn btn-info btn-sm">
                    <i class="fa fa-comments"></i> Lihat Tanggapan
                  </a>
                  <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function () {
    $('#dataTable').DataTable({
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Data tidak ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty": "Tidak ada data",
        "infoFiltered": "(difilter dari total _MAX_ data)"
      }
    });
  });
</script>


</body>
</html>