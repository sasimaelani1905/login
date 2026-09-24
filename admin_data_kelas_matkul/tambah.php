<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {

    $kode_akd = trim(mysqli_real_escape_string($con, $_POST['kode_akd']));
    $kode_matkul = trim(mysqli_real_escape_string($con, $_POST['kode_matkul']));
    $kode_jurusan = trim(mysqli_real_escape_string($con, $_POST['kode_jurusan']));
    $nik = trim(mysqli_real_escape_string($con, $_POST['nik']));
    $nama_kelas = trim(mysqli_real_escape_string($con, $_POST['nama_kelas']));

    $query = mysqli_query($con, "INSERT INTO tbl_kelas_matkul (kode_akd, kode_matkul, kode_jurusan, nik, nama_kelas)VALUES('$kode_akd', '$kode_matkul', '$kode_jurusan', '$nik', '$nama_kelas')");

    if ($query) {
        echo '<script>alert("Data Berhasil Disimpan");
            window.location.href="../admin_data_kelas_matkul";
        </script>';
    } else {
        die("Gagal menyimpan data: " . mysqli_error($con));
    }

} else {
    die("tidak terkirim.");
}
?>