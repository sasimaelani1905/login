<?php
require_once '../database/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | User Profile</title>
<?php
include '../css.php';
?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i> 
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="profile.php" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="../logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> keluar
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">SISTEM MANAJEMEN</a>
        </div>
      </div>
      <?php include '../sidebar_mahasiswa.php'; ?>
    </div>
  </aside>

  <!-- Query Data Berdasarkan NIM dari URL -->
  <?php 
    // Ambil NIM dari parameter URL (contoh: profile.php?nim=12345)
    $nim_get = isset($_GET['nim']) ? mysqli_real_escape_string($con, $_GET['nim']) : '';
    
    // Jalankan query khusus untuk 1 NIM tersebut
    $query_mhs = mysqli_query($con, "SELECT * FROM tbl_mhs WHERE nim = '$nim_get'") or die(mysqli_error($con));
    $data = mysqli_fetch_assoc($query_mhs);

    // Ambil variabel dari database
    $nim     = $data['nim'] ?? '';
    $nama    = $data['nama'] ?? '';
    $kontak  = $data['kontak'] ?? '';
    $email   = $data['email'] ?? '';
    $kelamin = $data['kelamin'] ?? '';
  ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid"></div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image Dinamis -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?=(!empty($foto))?$foto:'../aset_web/img/mhs_cewe.jpg'?>" alt="foto 1" class="img-fluid" style="width:190px" alt="User profile picture">
                </div>
                <!-- Tampilkan nama -->
                <h3 class="profile-username text-center"><?= htmlspecialchars($nama ?: 'Data Tidak Ditemukan'); ?></h3>
                <p class="text-muted text-center"><?= htmlspecialchars($nim); ?></p>
              </div>
            </div>
          </div>
          <!-- /.col -->

          <div class="col-md-9">
            <div class="card">
              <div class="card-body">
                <div class="tab-pane" id="settings">
                  <form class="form-horizontal">
                    
                    <div class="form-group row">
                      <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nim" value="<?= htmlspecialchars($nim); ?>" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" value="<?= htmlspecialchars($nama); ?>" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="kontak" class="col-sm-2 col-form-label">Kontak</label>
                      <div class="col-sm-10">
                        <input type="tel" class="form-control" id="kontak" value="<?= htmlspecialchars($kontak); ?>" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($email); ?>" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="kelamin" value="<?= htmlspecialchars($kelamin); ?>" readonly>
                      </div>
                    </div>

                  </form>
                </div>
              </div><!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
    </section>
  </div>

  <?php include '../footer.php'; ?>
</div>

<?php include '../script.php'; ?>
</body>
</html>