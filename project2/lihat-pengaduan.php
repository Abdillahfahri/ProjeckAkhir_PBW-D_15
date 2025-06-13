<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('db.php');


if (!isset($_SESSION['nik'])) {
    header("Location: index.php");
    exit;
}


if (isset($_GET['id_pengaduan'])) {
    $delete_id = mysqli_real_escape_string($db, $_GET['id_pengaduan']);
    

    $verify_query = mysqli_query($db, "SELECT * FROM pengaduan WHERE id_pengaduan='$delete_id' AND nik='$_SESSION[nik]'");
    
    if (mysqli_num_rows($verify_query) > 0) {

        $data = mysqli_fetch_assoc($verify_query);
        if (!empty($data['foto']) && file_exists("foto/".$data['foto'])) {
            unlink("foto/".$data['foto']);
        }
        

        $delete_query = mysqli_query($db, "DELETE FROM pengaduan WHERE id_pengaduan='$delete_id'");
        
        if ($delete_query) {

            header("Location: ".$_SERVER['PHP_SELF']."?url=data-pengaduan&delete_success=1");
            exit;
        } else {
            header("Location: ".$_SERVER['PHP_SELF']."?url=data-pengaduan&delete_error=1");
            exit;
        }
    } else {
        header("Location: ".$_SERVER['PHP_SELF']."?url=data-pengaduan&invalid_access=1");
        exit;
    }
}
?>

<?php

if (isset($_GET['success']) && $_GET['success'] === 'deleted') {
    echo '<div class="alert alert-success">Pengaduan berhasil dihapus</div>';
}

if (isset($_GET['error'])) {
    $errors = [
        'invalid_method' => 'Metode request tidak valid',
        'missing_id' => 'ID pengaduan tidak ditemukan',
        'not_owner' => 'Anda tidak memiliki akses untuk menghapus pengaduan ini',
        'delete_failed' => 'Gagal menghapus pengaduan'
    ];
    
    if (isset($errors[$_GET['error']])) {
        echo '<div class="alert alert-danger">'.$errors[$_GET['error']].'</div>';
    }
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
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Data Pengaduan</h6>
      <a href="?url=tulis-pengaduan" class="btn btn-success btn-sm">
        <i class="fa fa-plus"></i> Tambah Pengaduan
      </a>
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
                <td>
                  <?php 
                  $status = htmlspecialchars($data['status']);
                  $badge_class = '';
                  switch($status) {
                    case 'selesai': $badge_class = 'badge-success'; break;
                    case 'proses': $badge_class = 'badge-warning'; break;
                    default: $badge_class = 'badge-secondary';
                  }
                  ?>
                  <span class="badge <?= $badge_class ?>"><?= $status ?></span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <?php if ($data['status'] == '0'): ?>

                      <a href="edit-pengaduan.php?id=<?= $data['id_pengaduan']; ?>" 
                        class="btn btn-warning btn-sm rounded mr-1" 
                        title="Edit"
                        data-toggle="tooltip">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                    <?php else: ?>

                      <button class="btn btn-secondary btn-sm rounded mr-1" 
                              disabled 
                              title="Tidak dapat diedit - Status sudah diproses"
                              data-toggle="tooltip">
                        <i class="fas fa-edit"></i> Edit
                      </button>
                    <?php endif; ?>
                    

                    <a href="?url=detail-pengaduan&id=<?= $data['id_pengaduan']; ?>" 
                      class="btn btn-primary btn-sm rounded mr-1"
                      title="Detail"
                      data-toggle="tooltip">
                      <i class="fas fa-info-circle"></i> Detail
                    </a>
                    

                    <a href="?url=lihat-tanggapan&id=<?= $data['id_pengaduan']; ?>" 
                      class="btn btn-info btn-sm rounded mr-1"
                      title="Lihat Tanggapan"
                      data-toggle="tooltip">
                      <i class="fas fa-comments"></i> Tanggapan
                    </a>
                    

                    <form method="post" action="delete-pengaduan.php" style="display:inline;">
                      <input type="hidden" name="id_pengaduan" value="<?= $data['id_pengaduan'] ?>">
                      <button type="submit" 
                              class="btn btn-danger btn-sm rounded"
                              title="Hapus"
                              data-toggle="tooltip"
                              onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                        <i class="fas fa-trash-alt"></i> Hapus
                      </button>
                    </form>
                  </div>
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
      },
      "columnDefs": [
        { "orderable": false, "targets": [6] }
      ]
    });
  });
</script>

</body>
</html>