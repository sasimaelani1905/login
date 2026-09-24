<?php
require_once '../database/koneksi.php';
$authority = @$_SESSION['peran'];
if ($authority != 'A') {
  echo '<script>alert("Akun Ini Bukan Cross Authority Akan Segera Di Logout");</script>';
  echo '<script>window.location.href="../logout.php"</script>';
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  include '../css.php';
  $hal = 'periode_akademik';
  ?>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?= $_SESSION['nama']; ?> - [<?= $_SESSION['peran']; ?>]<i class="far fa-user"></i> 
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> keluar
          </a>
        </div>
      </li>
      <li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">SISTEM MANAJEMEN</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php
      include '../sidebar_admin.php';
      ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Periode Akademik</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>

              <a href="halaman_tambah.php" type="button" class="btn btn-success mb-2">Tambah Data 2</a>

              <a href="reset.php" type="button" class="btn btn-danger mb-2" onclick="return confirm('Anda Yakin Ingin Mereset Data Ini?')"><i class="fas fa-exclamation-triangle"></i> Reset Data</a>

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Kode Akademik</th>
                  <th>Semester</th>
                  <th>Tahun</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $panggil_data_akd = mysqli_query($con, "SELECT * FROM tbl_akademik") or die(mysqli_error($con));
                  $no = 1;
                  $rv = mysqli_num_rows($panggil_data_akd);
                  if ($rv > 0) {
                    while ($data = mysqli_fetch_array($panggil_data_akd)) {
                      $kode_akd = $data['kode_akd'];
                      $semester = $data['semester'];
                      $tahun = $data['tahun'];
                      $is_active = $data['is_active'];
                      ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($kode_akd) ?></td>
                        <td>
                          <?php
                          if ($semester == 'GN') {
                            echo 'Genap';
                          }else {
                            echo 'Ganjil';
                          }
                          ?>
                        </td>
                        <td><?= htmlspecialchars($tahun) ?></td>
                        <td>
                          <?php
                          if ($is_active == '1'){
                            echo '<span class="badge badge-success">Aktif</span>';
                          }else {
                            echo '<span class="badge badge-secondary">Tidak Aktif</span>';
                          }
                          ?>
                          </td>
                        <td> 
                          <a href="edit.php?kode_akd=<?= $data['kode_akd']; ?>&semester=<?=$data['semester'];?>&tahun=<?=$data['tahun'];?>&is_active=<?$data['is_active'];?>"
                          class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>

                          <a href="hapus.php?kode_akd=<?= $data['kode_akd']; ?>" 
                          class="btn btn-danger btn-sm" onclick="return confirm('Yakin Mau Hapus Data Ini?')">
                          <i class="fas fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php
                    }
                  }else {
                    echo '<center>Data Tidak Ditemukan</center>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
              <!-- /.card-body -->
          </div>
            <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Mahasiswa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="tambah.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label for="kode_akd">Kode AKD</label>
                <input type="number" name="kode_akd" class="form-control" id="kode_akd" placeholder="Masukan kode_akd" required>
              </div>

              <div class="form-group">
                <label for="semester">Semester</label>
                <select name="semester" class="form-control" id="semester" required>
                  <option value="" disabled selected>-- Pilih Semester --</option>
                  <option value="GN">Genap</option>
                  <option value="GL">Ganjil</option>
                </select>
              </div>

              <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="text" name="tahun" class="form-control" id="tahun" placeholder="Masukan Tahun" required>
              </div>

              <div class="form-group">
                <label for="is_active">Status Aktif</label>
                <select name="is_active" class="form-control" id="is_active" required>
                  <option value="" disabled selected>-- Pilih Status --</option>
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
              </div>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name="tambah_akd" class="btn btn-primary">Tambah</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  <!-- /.modal -->

  <!-- Main Footer -->
   <?php
    include '../footer.php';
    ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php
include '../script.php';
?>
</body>

</html>
<?php
}
?>