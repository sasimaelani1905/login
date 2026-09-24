<?php 
require_once '../database/koneksi.php'; 

$authority = @$_SESSION['peran']; 
if ($authority != 'D') { 
  echo '<script>alert("Akun ini melakukan cross authority, akan segera di logout");</script>'; 
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
  $hal = 'dosen_kelas_matkul'; 
  ?> 
</head> 
<body class="hold-transition sidebar-mini"> 
<div class="wrapper"> 

  <!-- Navbar --> 
  <nav class="main-header navbar navbar-expand navbar-white navbar-light"> 
    <ul class="navbar-nav"> 
      <li class="nav-item"> 
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a> 
      </li> 
    </ul> 
 
    <ul class="navbar-nav ml-auto"> 
      <li class="nav-item dropdown"> 
        <a class="nav-link" data-toggle="dropdown" href="#"> 
          <?= htmlspecialchars($_SESSION['nama'] ??'');?>-[<?= htmlspecialchars($_SESSION['peran'] ?? ''); ?>] 
          <i class="far fa-user"></i></a> 

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"> 
          <div class="dropdown-divider"></div> 
          <a href="#" class="dropdown-item"><i class="fas fa-user"></i>Profile</a> 
          <a href="../logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>Logout</a> 
        </div> 
      </li> 
    </ul> 
  </nav> 
 
 
  <!-- Sidebar --> 
  <aside class="main-sidebar sidebar-dark-primary elevation-4"> 
    <div class="sidebar"> 
      <div class="user-panel mt-3 pb-3 mb-3 d-flex"> 
        <div class="info"> 
          <a href="#" class="d-block">Sistem Manajemen</a> 
        </div> 
      </div> 
 
      <?php include '../sidebar_dosen.php'; ?> 

    </div> 
  </aside> 
 
 
  <!-- Content Wrapper --> 
  <div class="content-wrapper"> 
    <div class="content-header"> 
      <?php 
      $id_pertemuan             = isset($_GET['id_pertemuan'])? mysqli_real_escape_string($con, $_GET['id_pertemuan']):''; 
      $panggil_data_pertemuan   = mysqli_query($con, "SELECT * FROM tbl_pertemuan WHERE id_pertemuan ='$id_pertemuan'")or die(mysqli_error($con)); 
      $data_pertemuan           = mysqli_fetch_array($panggil_data_pertemuan); 
      $status_pertemuan         = isset($data_pertemuan['status'])? $data_pertemuan['status']: '1'; 
      $siap_simpan = isset($_SESSION['presensi_siap_simpan'][$id_pertemuan])&& $_SESSION['presensi_siap_simpan'][$id_pertemuan] == 1;

      $kode_kelas     = isset($_GET['id'])? mysqli_real_escape_string($con, $_GET['id']):(isset($data_pertemuan['id']) ? $data_pertemuan['id'] : ''); 
      $panggil_kelas  = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE id = '$kode_kelas'") or die(mysqli_error($con)); 
      $data_kelas     = mysqli_fetch_array($panggil_kelas); 

      $nik            = isset($data_kelas['nik'])?$data_kelas['nik']:''; 
      $kode_matkul    = isset($data_kelas['kode_matkul'])?$data_kelas['kode_matkul']:''; 
      $kode_jurusan   = isset($data_kelas['kode_jurusan'])?$data_kelas['kode_jurusan']:''; 

      $nama_kelas     = isset($data_kelas['nama_kelas'])? $data_kelas['nama_kelas']:''; 
      $hari_array     = array(
          'Sunday' => 'Minggu', 
          'Monday' => 'Senin', 
          'Tuesday' => 'Selasa', 
          'Wednesday' => 'Rabu', 
          'Thursday' => 'Kamis', 
          'Friday' => 'Jumat', 
          'Saturday' => 'Sabtu'); 
      $hari_ini       = $hari_array[date('l')]; 
      $hari           = isset($data_kelas['hari']) && !empty($data_kelas['hari'])? $data_kelas['hari']: $hari_ini; 
      $tanggal        = isset($data_pertemuan['tanggal'])? $data_pertemuan['tanggal']:date('d-m-Y'); 
      $pertemuan_ke   = isset($data_pertemuan['pertemuan_ke'])?$data_pertemuan['pertemuan_ke']:''; 

      $query_matkul   = mysqli_query($con, "SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($con)); 
      $data_matkul    = mysqli_fetch_array($query_matkul); 
      $nama_matkul    = isset($data_matkul['nama_matkul'])?$data_matkul['nama_matkul']:''; 

      $query_jurusan  = mysqli_query($con, "SELECT nama_jurusan FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan'") or die(mysqli_error($con)); 
      $data_jurusan   = mysqli_fetch_array($query_jurusan); 
      $nama_jurusan   = isset($data_jurusan['nama_jurusan'])? $data_jurusan['nama_jurusan']:''; 

      $ambil_dosen    = mysqli_query($con,"SELECT * FROM tbl_dosen WHERE nik='$nik'") or die(mysqli_error($con)); 
      $data_dosen     = mysqli_fetch_array($ambil_dosen); 
      $nama           = isset($data_dosen['nama'])? $data_dosen['nama']:''; 
      $kelamin        = isset($data_dosen['kelamin'])? $data_dosen['kelamin']:(isset($data_dosen['jk']) ? $data_dosen['jk'] : ''); 
      $foto           = isset($data_dosen['img'])?$data_dosen['img']:(isset($data_dosen['foto']) ? $data_dosen['foto'] : ''); 
      ?> 

      <div class="container-fluid"> 
        <h1 class="m-0">
          Kelas Mata Kuliah <?= htmlspecialchars($nama_kelas); ?>
        </h1> 
      </div> 

    </div> 
    <!-- /.content-header --> 

    <!-- Main Content --> 
    <div class="content"> 
      <div class="container-fluid"> 
        <div class="row"> 
          <div class="col-md-12"> 
            <div class="card card-primary card-outline"> 
              <div class="card-body"> 
                <div class="row"> 
                  
                  <div class="col-md-3 border-right"> 
                    <div class="box-profile text-center"> 
                      <?php  
                      if ($kelamin == 'L') { 
                      ?> 
                        <img src="<?= !empty($foto)?htmlspecialchars($foto):'../aset_web/img/mhs_cowo.png';?>"alt="foto 1"class="img-fluid" style="width:200px"> 
                      <?php 
                      } else { 
                      ?> 
                        <img src="<?= !empty($foto)?htmlspecialchars($foto):'../aset_web/img/mhs_cewe.jpg'; ?>"alt="foto 2" class="img-fluid" style="width:210px"> 
                      <?php 
                      } 
                      ?> 
                      <?php
                        if ($status_pertemuan == '1') {
                        ?>
                            <a href="ubah_status.php?id_pertemuan=<?= urlencode($id_pertemuan); ?>&status=0" class="btn btn-success btn-block mb-2"
                              onclick="return confirm('APAKAH ANDA YAKIN INGIN MEMBUKA PRESENSI INI?')">Buka Presensi</a>

                            <?php 
                            if ($siap_simpan) { 
                              ?>
                                <a href="simpan_presensi.php?id_pertemuan=<?= urlencode($id_pertemuan); ?>" class="btn btn-primary btn-block mb-2"
                                  onclick="return confirm('APAKAH ANDA YAKIN INGIN MENYIMPAN DATA PRESENSI?')">Simpan</a>
                            <?php 
                            } 
                            ?>

                        <?php
                        } else {
                        ?>
                            <a href="ubah_status.php?id_pertemuan=<?= urlencode($id_pertemuan); ?>&status=1" class="btn btn-danger btn-block mb-2"
                              onclick="return confirm('APAKAH ANDA YAKIN INGIN MENUTUP PRESENSI INI?')">Tutup Presensi</a>
                        <?php
                        }
                        ?>
                        <a href="javascript:history.back();" class="btn btn-secondary btn-block mt-3">
                            <i class="fas fa-arrow-left"></i>Kembali</a>
                    </div> 
                  </div> 

                  <div class="col-md-6 border-right"> 
                    <table class="table table-borderless table-sm"> 
                      <tr> 
                        <td style="width:35%;font-weight:600;">NIK</td> 
                        <td style="width:5%;">:</td> 
                        <td><?= htmlspecialchars($nik); ?></td> 
                      </tr> 
                      <tr> 
                        <td style="font-weight:600;">Nama</td> 
                        <td>:</td> 
                        <td><?= htmlspecialchars($nama); ?></td> 
                      </tr> 
                      <tr> 
                        <td style="font-weight:600;">Mata Kuliah</td> 
                        <td>:</td> 
                        <td><?= htmlspecialchars($nama_matkul); ?></td> 
                      </tr> 
                      <tr> 
                        <td style="font-weight:600;">Judul Materi</td> 
                        <td>:</td> 
                        <td><?= htmlspecialchars($data_pertemuan['judul_pertemuan']); ?></td> 
                      </tr> 
                      <tr> 
                        <td style="font-weight:600;">Kelas</td> 
                        <td>:</td> 
                        <td><?= htmlspecialchars($nama_kelas); ?></td> 
                      </tr> 
                      <tr> 
                        <td style="font-weight:600;">Jurusan</td> 
                        <td>:</td> 
                        <td><?= htmlspecialchars($nama_jurusan); ?></td> 
                      </tr> 
                      <tr> 
                        <td style="font-weight:600;">Hari</td> 
                        <td>:</td> 
                        <td><?= htmlspecialchars($hari); ?></td> 
                      </tr> 
                      <tr> 
                        <td style="font-weight:600;">Tanggal</td> 
                        <td>:</td> 
                        <td><?= htmlspecialchars($tanggal); ?></td> 
                      </tr> 
                      <tr> 
                        <td style="font-weight:600;">Pertemuan Ke</td> 
                        <td>:</td> 
                        <td><?= htmlspecialchars($pertemuan_ke); ?></td> 
                      </tr> 
                    </table> 
                  </div> 

                  <div class="col-md-3"> 
                    <div class="text-center"> 
                      <?php 
                      include('../aset_web/phpqrcode/qrlib.php'); 

                      $isi_qr = $id_pertemuan; 
                      $fileName = 'QR-presensi'.$id_pertemuan.'.png'; 

                      $alamat_tujuan = 'qr/'; 
                      if (!file_exists($alamat_tujuan)) { 
                        mkdir($alamat_tujuan, 0777, true); 
                      } 

                      $alamat_qr = $alamat_tujuan . $fileName; 

                      QRcode::png($isi_qr, $alamat_qr); 
                      ?> 
                      <img src="<?= htmlspecialchars($alamat_qr); ?>"alt="qr presensi"class="img-fluid mb-2" style="width:250px;"> 
                      <h5 class="font-weight-bold mb-3">Scan QR</h5> 

                      <?php if ($status_pertemuan == '0') { 
                        ?>
                      <div class="alert alert-warning p-2 mt-2">
                        <small class="d-block font-weight-bold text-danger m-0">SISA WAKTU</small>
                        <h4 id="demo" class="font-weight-bold text-danger m-0">01:10</h4>
                      </div>
                      <?php 
                      } else {
                        ?>
                      <div class="alert alert-secondary p-2 mt-2">
                        <small class="font-weight-bold text-muted">Presensi Ditutup</small>
                      </div>
                      <?php 
                      } 
                      ?>
                    </div> 
                  </div> 
                </div> 
              </div> 
            </div> 
          </div> 
        </div> 

        <div class="row"> 
          <div class="col-md-12"> 
            <div class="card card-primary"> 
              <div class="card-header"> 
                <h3 class="card-title">Data Presensi Mahasiswa</h3> 
              </div> 

              <div class="card-body table-responsive"> 
                <table id="example1" class="table table-bordered table-striped">
                  <thead> 
                    <tr> 
                      <th width="5%">No</th> 
                      <th>Mahasiswa</th> 
                      <th>Status Kehadiran</th> 
                      <th width="20%">Aksi</th> 
                    </tr> 
                  </thead> 
                  <tbody> 
                  <?php
                    $panggil_data_detail = mysqli_query($con, "SELECT * FROM tbl_detail_kelas_matkul WHERE id='$kode_kelas'") or die(mysqli_error($con));
                    $no = 1;

                    if (mysqli_num_rows($panggil_data_detail) > 0) {
                        while ($data = mysqli_fetch_array($panggil_data_detail)) {
                            $nim = $data['nim'];

                            $query_mahasiswa = mysqli_query($con, "SELECT nim, nama FROM tbl_mhs WHERE nim='$nim'") or die(mysqli_error($con));
                            $data_mahasiswa = mysqli_fetch_array($query_mahasiswa);
                            $nama_mhs = isset($data_mahasiswa['nama']) ? $data_mahasiswa['nama'] : 'Data Mahasiswa Tidak Ditemukan';

                            $query_presensi = mysqli_query($con, "SELECT * FROM tbl_presensi WHERE id_pertemuan='$id_pertemuan' AND nim='$nim'") or die(mysqli_error($con));
                            $data_presensi = mysqli_fetch_array($query_presensi);

                            $id_presensi = isset($data_presensi['id_presensi']) ? $data_presensi['id_presensi'] : '';
                            $status = isset($data_presensi['status_kehadiran']) ? $data_presensi['status_kehadiran'] : 'Belum Presensi';

                            if (isset($_SESSION['presensi_edit'][$id_pertemuan][$nim])) {
                                $status = $_SESSION['presensi_edit'][$id_pertemuan][$nim];
                            }

                            if (strtolower($status) == 'hadir') {
                                $warna = 'success';
                            } elseif (strtolower($status) == 'izin') {
                                $warna = 'primary';
                            } elseif (strtolower($status) == 'sakit') {
                                $warna = 'warning';
                            } elseif (strtolower($status) == 'alfa') {
                                $warna = 'danger';
                            } else {
                                $warna = 'secondary';
                            }
                    ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($nim); ?> - <?= htmlspecialchars($nama_mhs); ?></td>
                        <td><span class="badge badge-<?= $warna; ?>"><?= htmlspecialchars(ucfirst($status)); ?></span></td>
                        <td>
                            <?php 
                            if ($status_pertemuan == '0') { 
                              ?>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit-mhs" data-id_presensi="<?= htmlspecialchars($id_presensi); ?>"
                                    data-nim="<?= htmlspecialchars($nim); ?>" data-status="<?= htmlspecialchars($status); ?>"><i class="fas fa-pen"></i></button>
                            <?php 
                            } else { 
                              ?>
                            <button type="button" class="btn btn-secondary btn-sm" disabled><i class="fas fa-lock"></i> Edit</button>
                        <?php 
                        } 
                        ?>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">Data mahasiswa tidak ditemukan</td>
                    </tr>
                    <?php } ?>
                  </tbody> 
                </table> 
              </div> 
            </div> 
          </div> 
        </div> 
      </div> 
    </div> 
  </div> 

  <div class="modal fade" id="modal-edit-mhs">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Kehadiran Mahasiswa</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <form action="ubah_kehadiran.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_pertemuan" value="<?= htmlspecialchars($id_pertemuan); ?>">
                    <input type="hidden" name="id_presensi" id="modal_id_presensi">
                    <input type="hidden" name="nim" id="modal_nim">

                    <div class="form-group">
                        <label>Status Kehadiran</label>
                        <select name="status_kehadiran" id="status_kehadiran" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alfa">Alfa</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="btn_ubah_kehadiran" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark"></aside> 

  <!-- Footer -->
  <?php include '../footer.php'; ?> 
</div> 

<!-- Script -->
<?php include '../script.php'; ?> 

<script>
$('#modal-edit-mhs').on('show.bs.modal', function(e) {
    var button = $(e.relatedTarget);
    $('#modal_id_presensi').val(button.attr('data-id_presensi'));
    $('#modal_nim').val(button.attr('data-nim'));
    $('#status_kehadiran').val(button.attr('data-status'));
});
</script> 

<?php if ($status_pertemuan == '0') { ?>
<script> 
// Hitung mundur 1 Menit (60.000 milidetik) dari waktu halaman dibuka
var countDownDate = new Date().getTime() + (1 * 60 * 1000); 

var x = setInterval(function() { 
  var now = new Date().getTime(); 
  var distance = countDownDate - now; 
 
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)); 
  var seconds = Math.floor((distance % (1000 * 60)) / 1000); 
 
  // Format tampilan angka agar selalu dua digit (contoh: 00:09)
  minutes = minutes < 10 ? "0" + minutes : minutes;
  seconds = seconds < 10 ? "0" + seconds : seconds;

  var element = document.getElementById("demo");
  if (element) {
    element.innerHTML = minutes + ":" + seconds; 
  }
 
  // Ketika hitung mundur selesai
  if (distance < 0) { 
    clearInterval(x); 
    if (element) {
      element.innerHTML = "WAKTU HABIS"; 
    }
    alert("Waktu presensi telah habis! Presensi akan otomatis ditutup.");
    // Otomatis ubah status presensi menjadi tertutup (status=1)
    window.location.href = "ubah_status.php?id_pertemuan=<?= urlencode($id_pertemuan); ?>&status=1"; 
  } 
}, 1000); 
</script> 
<?php } ?>

</body> 
</html> 
<?php  
} 
?>