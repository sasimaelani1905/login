<?php 
require_once '../database/koneksi.php';

if (isset($_POST['tambah_akd'])) {
    
    $kode_akd  = trim(mysqli_real_escape_string($con, $_POST['kode_akd']));
    $semester  = trim(mysqli_real_escape_string($con, $_POST['semester']));
    $tahun     = trim(mysqli_real_escape_string($con, $_POST['tahun']));
    $is_active = trim(mysqli_real_escape_string($con, $_POST['is_active']));

    $allowed_semester = ['GN', 'GL'];
    $allowed_status   = ['0', '1'];

    if (!in_array($semester, $allowed_semester) || !in_array($is_active, $allowed_status)) {
        echo '<script>alert("Pilihan semester atau status aktif tidak valid!"); window.history.back();</script>';
        exit;
    }

    $cek_akd = mysqli_query($con, "SELECT kode_akd FROM tbl_akademik WHERE kode_akd = '$kode_akd'") or die(mysqli_error($con));

    if (mysqli_num_rows($cek_akd) > 0) {
        echo '<script>alert("Kode Akademik sudah terdaftar!"); window.history.back();</script>';
    } else {
        $query_simpan = mysqli_query($con, "INSERT INTO tbl_akademik (kode_akd, semester, tahun, is_active) VALUES ('$kode_akd', '$semester', '$tahun', '$is_active')") or die(mysqli_error($con));

        if ($query_simpan) {
            echo '<script>
                    alert("Data berhasil disimpan");
                    window.location.href = "../admin_periode_akademik/";
                  </script>';
        }
    }
}
?>