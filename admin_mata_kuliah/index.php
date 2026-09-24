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

  $hal = 'mata_kuliah';
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
              <h3 class="card-title">Data Mata Kuliah</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
              <a href="halaman_tambah.php" type="button" class="btn btn-success mb-2">Tambah Data 2</a>
              <a href="reset_data.php" type="button" class="btn btn-danger mb-2" onclick="return confirm('Anda Yakin Ingin Mereset Data Ini?')"><i class="fas fa-exclamation-triangle"></i> Reset Data</a>

              <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i>Impor Data</button>

              <a href="pdf.php" type="button" target="_blank" class="btn btn-danger mb-2"><i class="fas fa-file-pdf"></i> Ekspor Data</a>
              <a href="excel.php" type="button" target="_blank" class="btn btn-success mb-2"><i class="fas fa-file-excel"></i> Ekspor Data</a>

              <?php
              $pengguna = $_SESSION['username'];
              ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Kode Matkul</th>
                  <th>Nama Matkul</th>
                  <th>Jumlah SKS</th>
                  <th>Jumlah CPMK</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $panggil_data_matkul = mysqli_query($con, "SELECT * FROM tbl_matkul") or die(mysqli_error($con));
                  $no = 1;
                  $rv = mysqli_num_rows($panggil_data_matkul);
                  if ($rv > 0) {
                    while ($data = mysqli_fetch_array($panggil_data_matkul)) {
                      $kode_matkul = $data['kode_matkul'];
                      $nama_matkul = $data['nama_matkul'];
                      $jml_sks = $data['jml_sks'];
                      $jml_cpmk = $data['jml_cpmk'];
                      ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $kode_matkul ?></td>
                        <td><?= $nama_matkul ?></td>
                        <td><?= $jml_sks ?></td>
                        <td><?= $jml_cpmk ?></td>
                        <td> 
                          <a href="edit.php?kode_matkul=<?= $data['kode_matkul']; ?>&nama_matkul=<?=$data['nama_matkul'];?>&jml_sks=<?=$data['jml_sks'];?>&jml_cpmk=<?$data['jml_cpmk'];?>" 
                          class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>

                          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" data-kode="<?= $data['kode_matkul'];?>" data-nama="<?= $data['nama_matkul'];?>" data-sks="<?=$data['jml_sks'];?>" data-cpmk="<?=$data['jml_cpmk'];?>"><i class="fas fa-edit"></i></button>

                          <a href="hapus.php?kode_matkul=<?= $data['kode_matkul']; ?>" 
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
            <h4 class="modal-title">Tambah Data Mata Kuliah</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="tambah.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label for="kode_matkul">Kode Mata Kuliah</label>
                <input type="text" name="kode_matkul" class="form-control" id="kode_matkul" placeholder="Masukan Kode Mata Kuliah" required>
              </div>
              <div class="form-group">
                <label for="nama_matkul">Nama Mata Kuliah</label>
                <input type="text" name="nama_matkul" class="form-control" id="nama_matkul" placeholder="Masukan Nama Mata Kuliah" required>
              </div>
              <div class="form-group">
                <label for="jml_sks">Jumlah SKS</label>
                <input type="number" name="jml_sks" class="form-control" id="jml_sks" placeholder="Masukan Jumlah SKS" required>
              </div>
              <div class="form-group">
                <label for="jml_cpmk">Jumlah CPMK</label>
                <input type="number" name="jml_cpmk" class="form-control" id="jml_cpmk" placeholder="Masukan Jumlah CPMK" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name ="tambah_matkul" class="btn btn-primary">Tambah</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-edit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data Mata Kuliah</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="ubah.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label for="kode_matkul">Kode Mata Kuliah</label>
                <input type="text" name="kode_matkul" class="form-control" id="kode_matkul" placeholder="Masukan Kode Mata Kuliah" required readonly>
              </div>
              <div class="form-group">
                <label for="nama_matkul">Nama Mata Kuliah</label>
                <input type="text" name="nama_matkul" class="form-control" id="nama_matkul" placeholder="Masukan Nama Mata Kuliah" required>
              </div>
              <div class="form-group">
                <label for="jml_sks">Jumlah SKS</label>
                <input type="number" name="jml_sks" class="form-control" id="jml_sks" placeholder="Masukan Jumlah SKS" required>
              </div>
              <div class="form-group">
                <label for="jml_cpmk">Jumlah CPMK</label>
                <input type="number" name="jml_cpmk" class="form-control" id="jml_cpmk" placeholder="Masukan Jumlah CPMK" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name ="edit_matkul" class="btn btn-primary">Edit</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  <!-- /.modal -->

<div class="modal fade" id="modal-impor">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Impor Data Mata Kuliah</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="impor.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-grup">
                <label for="file">Upload File Template</label>
                <input type="file" class="form-control" name="file_excel" required>
                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-download"><i class="fas fa-file-excel"></i>Downloand</button>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name ="btn_impor" class="btn btn-primary">Impor</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
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
<script>
  $('#modal-edit').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('kode');
    var nama = $(e.relatedTarget).data('nama');
    var sks = $(e.relatedTarget).data('sks');
    var cpmk = $(e.relatedTarget).data('cpmk');

    $(e.currentTarget).find('input[name="kode_matkul"]').val(kode);
    $(e.currentTarget).find('input[name="nama_matkul"]').val(nama);
    $(e.currentTarget).find('input[name="jml_sks"]').val(sks);
    $(e.currentTarget).find('input[name="jml_cpmk"]').val(cpmk);

  })
</script>
</body>

</html>
<?php
}
?>