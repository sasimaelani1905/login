 <?php
 require_once'../database/koneksi.php'; 
 ?>
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
    $nomor_urut = '1';
    $id = @$_GET['$kode_kelas'];
    $id_pertemuan = @$_GET['$id_pertemuan'];
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