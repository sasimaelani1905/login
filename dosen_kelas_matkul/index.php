<?php
require_once '../database/koneksi.php';
$authority = @$_SESSION['peran'];
if ($authority != 'D') {
  echo '<script>alert("akun ini melakukan cross authority, akan segera di logout");</script>';
  echo '<script>window.location.href= "../logout.php" </script>';
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
 include'../css.php';
 

$hal = 'dosen_kelas_matkul';
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
         <?= $_SESSION['nama']; ?> <?= $_SESSION['peran']; ?> <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user"></i> PROFILE
          </a>
          <div class="dropdown-divider"></div>
          
          <div class="dropdown-divider"></div>
          <a href="../logout.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> LOGOUT
          </a>
          <div class="dropdown-divider"></div>
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
      include'../sidebar_dosen.php';
      ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content">
        <div class="container-fluid">
            <form action="" method="post">
                <div class="row">
                    <div class="col-3">
                        <?php 
                          $pengguna = $_SESSION['username'];
                          $panggil_periode_akademik = mysqli_query($con, "SELECT * FROM tbl_akademik WHERE kode_akd IN (SELECT DISTINCT kode_akd FROM tbl_kelas_matkul WHERE nik = '$pengguna')") or die(mysqli_error($con));
                        ?>
                        <div class="form-group">                   
                            <select class="form-control" name="kode_akd" id="">
                              <option value="">--Masukan Periode Akademik--</option> 
                                <?php 
                                while ($data_periode = mysqli_fetch_array($panggil_periode_akademik)){
                                    $kode_akd = $data_periode['kode_akd'];
                                    $semester = $data_periode['semester'];
                                    $tahun = $data_periode['tahun'];?>
                                <option value="<?= $kode_akd; ?>"><?= $tahun?> - <?= ($semester == 'GL')? 'Ganjil' : 'Genap'?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>    
                    <button type="submit" name="btn_cari" class="btn btn-primary"><i class="fas fa-search">
                          </i> Tampilkan Data</button>
                  </div>
                </form>
            <!-- Main Footer -->
 

            <?php 
            if (isset($_POST['btn_cari'])){
              
              $filter = trim(mysqli_real_escape_string($con, $_POST['kode_akd']));
            ?>
            <div class="row">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Kelas Mata Kuliah</h3>
                    </div>
                    <div class="card-body">
                <?php
                  $pengguna = $_SESSION['username'];
                ?>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr class="text-center">
                      <th>ID</th>
                      <th>Nama Kelas</th>
                      <th>Kode Akademik</th>
                      <th>Kode Mata Kuliah</th>
                      <th>Kode Jurusan</th>
                      <th>NIK</th>
                      <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      $pengguna - $_SESSION['username'];
                      $panggil_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE kode_akd = '$filter' AND nik='$pengguna'") or die(mysqli_error($con));

                      $no = 1;
                      $rv = mysqli_num_rows($panggil_kelas);
                      if ($rv > 0){
                          while ($data = mysqli_fetch_array($panggil_kelas)){
                              $id = $data['id'];
                              $nama_kelas = $data['nama_kelas'];
                              $kode_akd = $data['kode_akd'];
                              $kode_matkul = $data['kode_matkul'];
                              $kode_jurusan = $data['kode_jurusan'];
                              $nik = $data['nik'];
                              
                              ?>
                              <tr class="text-center">
                                  <td><?= $id; ?></td>
                                  <td><?= $nama_kelas; ?></td>
                                  <td>
                                  <?php
                                  $query_akademik= mysqli_query($con, "SELECT tahun, semester FROM tbl_akademik WHERE kode_akd='$kode_akd'")or die(mysqli_error($con));
                                  $data_akd = mysqli_fetch_array($query_akademik);
                                  echo $data_akd['tahun'].'-'.($data_akd['semester']=='GL'? 'Ganjil':'Genap');
                                   ?>
                                   </td>
                                  <td>
                                  <?php
                                  $query_matkul= mysqli_query($con, "SELECT kode_matkul, nama_matkul FROM tbl_matkul WHERE kode_matkul='$kode_matkul'")or die(mysqli_error($con));
                                  $data_matkul = mysqli_fetch_array($query_matkul);
                                  echo $data_matkul['kode_matkul'].'-'.$data_matkul['nama_matkul'];
                                  ?>
                                  </td>
                                  <td>
                                  <?php
                                  $query_jurusan= mysqli_query($con, "SELECT kode_jurusan, nama_jurusan FROM tbl_jurusan WHERE kode_jurusan='$kode_jurusan'")or die(mysqli_error($con));
                                  $data_jurusan = mysqli_fetch_array($query_jurusan);
                                  echo $data_jurusan['kode_jurusan'].'-'.$data_jurusan['nama_jurusan'];
                                  ?>
                                  </td>
                                  <td>
                                  <?php
                                  $query_dosen= mysqli_query($con, "SELECT nik, nama FROM tbl_dosen WHERE nik='$nik'")or die(mysqli_error($con));
                                  $data_dosen = mysqli_fetch_array($query_dosen);
                                  echo $data_dosen['nik'].'-'.$data_dosen['nama'];
                                  ?>
                                  </td>
                                  <td>
                                    <a href="../dosen_kelas_matkul/index.php?id=<?= $data['id']; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>

                                    <a href="../dosen_kelas_matkul/pertemuan.php?id=<?= $data['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-qrcode"></i></a>

                                    <a href="edit.php?id=<?= $data['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                
                                    <a href="hapus.php?id=<?= $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">
                                      <i class="fas fa-trash"></i></a>
                                  </td>
                              </tr>
                              <?php
                                  }
                              } else {
                                  ?>
                                  <tr>
                                      <td colspan="8" class="text-center">Data tidak ditemukan</td> 
                                  </tr>
                                  <?php
                              }   
                              ?>
                      </tbody>
                      </table>
                  </div>
                </div>
            </div>
            <?php 
            }
            ?>
        </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
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
<?php 
 include'../footer.php';
?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php 
 include'../script.php';
?>

<script>
  $('#modal-edit').on('show.bs.modal', function(e) {
    var id =$(e.relatedTarget).data('id');
    var kode_akd = $(e.relatedTarget).data('kode_akd');
    var kode_matkul = $(e.relatedTarget).data('kode_matkul');
    var kode_jurusan = $(e.relatedTarget).data('kode_jurusan');
    var nik = $(e.relatedTarget).data('nik');
    var nama_kelas = $(e.relatedTarget).data('nama_kelas');
    
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="kode_akd"]').val(kode_akd);
    $(e.currentTarget).find('input[name="kode_matkul"]').val(kode_matkul);
    $(e.currentTarget).find('input[name="kode_jurusan"]').val(kode_jurusan);
    $(e.currentTarget).find('input[name="nik"]').val(nik);
    $(e.currentTarget).find('select[name="nama_kelas"]').val(nama_kelas);
  })
</script>

</body>
</html>
<?php 
}
?>