<?php
require_once '../database/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  include '../css.php';
  $hal = 'data_kelas_matkul';
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
          <?= $_SESSION['nama'] ?? ''; ?> - [<?= $_SESSION['peran'] ?? ''; ?>]<i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user"></i> Profile
          </a>
          <a href="../logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> Logout
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
          <a href="#" class="d-block">SISTEM MANAJEMAN</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php include '../sidebar_admin.php'; ?>
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
            <h3 class="card-title">Edit Data Kelas Matkul</h3>
          </div>
          <!-- /.card-header -->
          
          <div class="card-body">
            <?php 
            $id_edit = @$_GET['id'];
            $ambil_data = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE id = '$id_edit'") or die(mysqli_error($con));
            $data = mysqli_fetch_array($ambil_data);

            $id = $data['id'] ?? '';
            $kode_akd = $data['kode_akd'] ?? '';
            $kode_matkul = $data['kode_matkul'] ?? '';
            $kode_jurusan = $data['kode_jurusan'] ?? '';
            $nik = $data['nik'] ?? '';
            $nama_kelas = $data['nama_kelas'] ?? '';
            ?>

            <form action="ubah.php" method="post"> 
              <div class="form-group">
                <label for="id">ID</label>
                <input type="number" name="id_disable" class="form-control" id="id" value="<?=$id;?>" placeholder="Masukan ID" disabled>
                <input type="number" name="id" class="form-control" value="<?=$id?>" hidden>
              </div>

              <div class="form-group">
                <label for="kode_akd">Periode Akademik</label>
                <select name="kode_akd" id="kode_akd" class="form-control" required>
                  <option value="">Pilih Kode Akademik</option>
                  <?php 
                  $query_akd = mysqli_query($con, "SELECT * FROM tbl_akademik") or die(mysqli_error($con));
                  while ($data_akd = mysqli_fetch_array($query_akd)) {
                      $sem = ($data_akd['semester'] == 'GL') ? 'Ganjil' : 'Genap';
                      $selected = ($data_akd['kode_akd'] == $kode_akd) ? 'selected' : '';
                      echo "<option value='".$data_akd['kode_akd']."' $selected>".$data_akd['kode_akd']." - ".$data_akd['tahun']." (".$sem.")</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="kode_matkul">Kode Mata Kuliah</label>
                <select name="kode_matkul" id="kode_matkul" class="form-control" required>
                  <option value="">Pilih Mata Kuliah</option>
                  <?php 
                  $query_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul") or die(mysqli_error($con));
                  while ($data_matkul = mysqli_fetch_array($query_matkul)) {
                    
                      $selected = ($data_matkul['kode_matkul'] == $kode_matkul) ? 'selected' : '';
                      echo "<option value='".$data_matkul['kode_matkul']."' $selected>".$data_matkul['kode_matkul']." - ".$data_matkul['nama_matkul']."</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="kode_jurusan">Kode Jurusan</label>
                <select name="kode_jurusan" id="kode_jurusan" class="form-control" required>
                  <option value="">Pilih Jurusan</option>
                  <?php 
                  $query_jurusan = mysqli_query($con, "SELECT * FROM tbl_jurusan") or die(mysqli_error($con));
                  while ($data_jurusan = mysqli_fetch_array($query_jurusan)) {
                     
                      $selected = ($data_jurusan['kode_jurusan'] == $kode_jurusan) ? 'selected' : '';
                      echo "<option value='".$data_jurusan['kode_jurusan']."' $selected>".$data_jurusan['kode_jurusan']." - ".$data_jurusan['nama_jurusan']."</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="nik">NIK Dosen</label>
                <select name="nik" id="nik" class="form-control" required>
                  <option value="">Pilih Dosen</option>
                  <?php 
                  $query_dosen = mysqli_query($con, "SELECT * FROM tbl_dosen") or die(mysqli_error($con));
                  while ($data_dosen = mysqli_fetch_array($query_dosen)) {
                     
                      $selected = ($data_dosen['nik'] == $nik) ? 'selected' : '';
                      echo "<option value='".$data_dosen['nik']."' $selected>".$data_dosen['nik']." - ".$data_dosen['nama']."</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" maxlength="150" name="nama_kelas" class="form-control" id="nama_kelas" value="<?=$nama_kelas;?>" placeholder="Masukan Nama Kelas" required>
              </div>

              <div class="card-footer px-0">
                <button type="submit" name="btn-edit" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-default">Kembali</a>
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
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include '../footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>
</body>
</html>