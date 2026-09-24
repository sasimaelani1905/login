<?php 
require_once'../database/koneksi.php';

if (isset($_POST['tambah_akd'])) {
    
        $kode_akd = trim(mysqli_real_escape_string($con, $_POST['kode_akd']));
        $semester = trim(mysqli_real_escape_string($con, $_POST['semester']));
        $tahun = trim(mysqli_real_escape_string($con, $_POST['tahun']));
        $is_active = trim(mysqli_real_escape_string($con, $_POST['is_active']));

        $cek_akd = mysqli_query($con, "SELECT kode_akd FROM tbl_akademik WHERE kode_akd = '$kode_akd'")or die(mysqli_error($con));

        $rv = mysqli_num_rows($cek_akd);
        if ($rv == 1) {
        echo '<script> alert ("kode Akademik sudah terdaftar") </script>';
        }else {
            $query_simpan = mysqli_query($con, "INSERT INTO tbl_akademik (kode_akd, semester, tahun, is_active) VALUES ('$kode_akd','$semester','$tahun','$is_active')")or die(mysqli_error($con));

            echo '<script> alert ("data berhasil di simpan");
            window.location.href = "../admin_periode_akademik/"</script>';
        }
}

?>