<?php
require_once '../database/koneksi.php';
$authority = @$_SESSION['peran'];
if ($authority != 'A') {
  echo '<script>alert("Akun ini melakukan cross authority, akan segera di logout");</script>';
  echo '<script>window.location.href="../logout.php"</script>';
}else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  include'../css.php';
  require_once '../database/koneksi.php';
  $hal ='halaman_tambah_dosen';
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
         <?= $_SESSION['nama']; ?> - [<?= $_SESSION['peran']; ?>] <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user"></i> Profile
          </a>
          <a href="../logout.php" class="dropdown-item">
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
          <a href="#" class="d-block">Sistem Manajemen</a>
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
       <div class="row">
        <div class="col-lg-6">
            <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Tambah Data 2</h3>
            </div>
            <div class="card-body">
                <form action="tambah.php" method="post">
                <div class="form-group">
                  <label for="nik">Nik</label>
                <input type="number" name="nik" class="form-control" id="nik" placeholder="Masukan Nik" required>
              </div>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
              </div>
              <div class="form-group">
                <label for="kontak">Kontak</label>
                <input type="tel" name="kontak" class="form-control" id="kontak" placeholder="Masukan Kontak" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Masukan Email" required>
              </div>
              <div class="form-group">
                <label>Kelamin</label>
                <select class="form-control" name="kelamin">
                  <option value="">--Pilih Jenis Kelamin--</option>
                  <option value="P">Perempuan</option>
                  <option value="L">Laki-Laki</option>
                </select>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="submit" name="btn_tambah" class="btn btn-primary btn-block">Tambah</button>
            </div>
          </form>
          </div>
          </div>
        </div>
       </div>
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

  <!-- Main Footer -->
    <?php include '../footer.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php' ?>
</body>
</html>
<?php 
}
?>