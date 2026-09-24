<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    $id = trim(mysqli_real_escape_string($con, $_POST['id']));
    $kode_akd = trim(mysqli_real_escape_string($con, $_POST['kode_akd']));
    $kode_matkul = trim(mysqli_real_escape_string($con, $_POST['kode_matkul']));
    $kode_jurusan = trim(mysqli_real_escape_string($con, $_POST['kode_jurusan']));
    $nik = trim(mysqli_real_escape_string($con, $_POST['nik']));
    $nama_kelas = trim(mysqli_real_escape_string($con, $_POST['nama_kelas']));

    $update = mysqli_query($con, "UPDATE tbl_kelas_matkul SET 
        kode_akd = '$kode_akd',
        kode_matkul = '$kode_matkul',
        kode_jurusan = '$kode_jurusan',
        nik = '$nik',
        nama_kelas = '$nama_kelas'
        WHERE id = '$id'") or die(mysqli_error($con));

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!'); window.location='index.php';</script>";
    }
}
?>