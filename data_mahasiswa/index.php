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

  $hal = 'mhs_mahasiswa';
  ?>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
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
          <a href="profile.php" class="dropdown-item">
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
              <h3 class="card-title">Data Mahasiswa</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
              <a href="halaman_tambah.php" type="button" class="btn btn-primary mb-2">Tambah Data 2</a>

              <a href="reset.php" type="button" class="btn btn-danger mb-2" onclick="return confirm('Anda Yakin Ingin Mereset Data Ini?')"><i class="fas fa-exclamation-triangle"></i> Reset Data</a>

              <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i>Impor Data</button>

              <a href="pdf.php" class = "btn btn-danger mb-2" target ="_blank"><i class ="fas fa-file-pdf"></i> Ekspor PDF </a>

              <a href="excel.php" class = "btn btn-success mb-2" target ="_blank"><i class ="fas fa-file-excel"></i> Ekspor Excel </a>
              
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Nim</th>
                  <th>Nama</th>
                  <th>Kontak</th>
                  <th>Email</th>
                  <th>Kelamin</th>
                  <th>Foto</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $panggil_data_mahasiswa = mysqli_query($con, "SELECT * FROM tbl_mhs") or die(mysqli_error($con));
                  $no = 1;
                  $rv = mysqli_num_rows($panggil_data_mahasiswa);
                  if ($rv > 0) {
                    while ($data = mysqli_fetch_array($panggil_data_mahasiswa)) {
                      $nim = $data['nim'];
                      $nama = $data['nama'];
                      $kontak = $data['kontak'];
                      $email = $data['email'];
                      $kelamin = $data['kelamin'];
                      $foto = $data['img'];
                      ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $nim ?></td>
                        <td><?= $nama ?></td>
                        <td><?= $kontak ?></td>
                        <td><?= $email ?></td>
                        <td><?php
                        $kelamin =$data['kelamin'];
                        if ($kelamin == 'L') {
                          echo 'laki-laki';
                        }else{
                          echo 'perempuan';
                        }?>
                        </td>
                        <td>
                        <?php 
                        if ($kelamin == 'L'){
                          ?>
                          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-img" data-nim="<?=$nim ?>">
                          <img src="<?=(!empty($foto))?$foto:'../aset_web/img/mhs_cowo.png'?>" alt="foto 1" class="img-fluid" style="width:60px"></button>
                          <?php
                        }else {
                          ?>
                          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-img" data-nim="<?=$nim ?>">
                          <img src="<?=(!empty($foto))?$foto:'../aset_web/img/mhs_cewe.jpg'?>" alt="foto 1" class="img-fluid" style="width:60px"></button>
                          <?php
                        }
                        ?>
                        </td>
                        <td> 
                          <a href="edit.php?nim=<?= $data['nim']; ?>&nama=<?=$data['nama'];?>&kontak=<?=$data['kontak'];?>&email=<?$data['email'];?>&kelamin=<?=$data['kelamin'];?>" 
                          class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>

                          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" data-nim="<?= $nim;?>" data-nama="<?= $nama;?>" data-kontak="<?= $kontak;?>" data-email="<?= $email;?>" data-kelamin="<?= $kelamin;?>"><i class="fas fa-edit"></i></button>

                          <a href="hapus.php?nim=<?= $data['nim']; ?>" 
                          class="btn btn-danger btn-sm" onclick="return confirm('Yakin Mau Hapus Data Ini?')">
                          <i class="fas fa-trash"></i></a>

                          <a href="detail.php?nim=<?= $data['nim']; ?>&nama=<?=$data['nama'];?>&kontak=<?=$data['kontak'];?>&email=<?$data['email'];?>&kelamin=<?=$data['kelamin'];?>" 
                          class="btn btn-secondary btn-sm"><i class="fas fa-user"></i></a>
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
                <label for="nim">Nim</label>
                <input type="number" name="nim" class="form-control" id="nim" placeholder="Masukan Nim" required>
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
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name ="tambah_mahasiswa" class="btn btn-primary">Tambah</button>
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
            <h4 class="modal-title">Edit Data Mahasiswa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="ubah.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label for="nim">Nim</label>
                <input type="number" name="nim" class="form-control" id="nim" placeholder="Masukan Nim" required>
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
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name ="edit_mahasiswa" class="btn btn-primary">Edit</button>
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
            <h4 class="modal-title">Impor Data Mahasiswa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="impor.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-grup mb-3">
                <label for="file">Download Template Excel</label>
                <a href="template/kosongan.xls" class="btn btn-success btn-sm">
                <i class="fas fa-download"></i>Download
                </a>
              </div>
              <div class="form-grup mb-3">
                <label for="file">Upload File Template Excel</label><br>
                <input type="file" class="form-control" name="file_excel" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name ="impor_mhs" class="btn btn-primary">Impor</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-img">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Foto Mahasiswa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="foto.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-grup mb-3">
                <label for="file">Upload Foto</label><br>
                <input type="file" class="form-control" name="file_foto" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name ="btn_foto" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  <!-- Main Footer -->
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
  $('#modal-edit').on('show.bs.modal', function(e) {
    var nim = $(e.relatedTarget).data('nim');
    var nama = $(e.relatedTarget).data('nama');
    var kontak = $(e.relatedTarget).data('kontak');
    var email = $(e.relatedTarget).data('email');
    var kelamin = $(e.relatedTarget).data('kelamin');
    
    $(e.currentTarget).find('input[name="nim"]').val(nim);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="kontak"]').val(kontak);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('select[name="kelamin"]').val(kelamin);

    
  })
</script>
<script>
  $('#modal-img').on('show.bs.modal', function (e) {
    var nim = $(e.relatedTarget).data('nim');

    $(e.currentTarget).find('input[name="nim"]').val(nim);
  })
</script>
</body>

</html>
<?php
}
?>