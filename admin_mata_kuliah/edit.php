<?php
require_once '../database/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  include'../css.php';

  $hal ='mata_kuliah';
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
            <i class="fas fa-user"></i> Profile
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

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
    include '../sidebar_admin.php' ?>
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
        <h3 class="card-title">Edit Data Mata Kuliah</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
                <?php 
                $kode_matkul = @$_GET['kode_matkul'];
                $ambil_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul WHERE kode_matkul ='$kode_matkul'")or die (mysqli_error($con));
                $data_matkul = mysqli_fetch_array($ambil_matkul);
                $nama_matkul = $data_matkul['nama_matkul'];
                $jml_sks = $data_matkul['jml_sks'];
                $jml_cpmk = $data_matkul['jml_cpmk'];
                ?>
                <form action="ubah.php" method="post">
                <div class="form-group">
                  <label for="kode_matkul">kode_matkul</label>
                  <input type="text" name="kode_matkul_disable" class="form-control" id="kode_matkul_disable" value="<?= $kode_matkul; ?>" placeholder="Masukan kode matkul" disabled>
                  <input type="text" name="kode_matkul" class="form-control" id="kode_matkul" value="<?= $kode_matkul; ?>" placeholder="Masukan kode matkul" hidden>
                </div>
                <div class="form-group">
                  <label for="nama_matkul">Nama Matkul</label>
                  <input type="text" name="nama_matkul" class="form-control" id="nama_matkul" value="<?= $nama_matkul; ?>" placeholder="Masukan Nama Matkul" required>
                </div>
                <div class="form-group">
                  <label for="jml_sks">Jumlah SKS</label>
                  <input type="number" name="jml_sks" class="form-control" id="jml_sks" value="<?= $jml_sks; ?>" placeholder="Masukan Jumlah SKS" required>
                </div>
                <div class="form-group">
                  <label for="jml_cpmk">Jumlah CPMK</label>
                  <input type="number" name="jml_cpmk" class="form-control" id="jml_cpmk" value="<?= $jml_cpmk; ?>" placeholder="Masukan Jumlah CPMK" required>
                </div>
              </div>
              <div class="model-footer justify-content-between">
                <button type="submit" name="edit_matkul" class="btn btn-primary btn-block"></button>
              </div>
            </form>
          </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.container-fluid -->
</div>
    <!-- /.content -->
</div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
      <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Pengguna</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="tambah.php" method="post">
            
            </form>

      
  <!-- Main Footer -->
    <?php include '../footer.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php' ?>
</body>
</html>