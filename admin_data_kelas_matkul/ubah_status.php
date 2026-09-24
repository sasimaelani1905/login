<?php
require_once '../database/koneksi.php';
if (isset($_GET['id_pertemuan']) && isset($_GET['status'])) {

    $id_pertemuan = trim(mysqli_real_escape_string($con, $_GET['id_pertemuan']));
    $status = trim(mysqli_real_escape_string($con, $_GET['status']));

    $cek = mysqli_query($con,"SELECT * FROM tbl_pertemuan WHERE id_pertemuan='$id_pertemuan'") or die(mysqli_error($con));
    if (mysqli_num_rows($cek) == 0) {
        echo '<script>alert("Data pertemuan tidak ditemukan");
                window.history.back();</script>';
        exit;
    }

    $query = mysqli_query($con, "UPDATE tbl_pertemuan SET status='$status' WHERE id_pertemuan='$id_pertemuan'") or die(mysqli_error($con));
    if ($query) {
        if ($status == '0') {
            unset($_SESSION['presensi_siap_simpan'][$id_pertemuan]);
            echo '<script>alert("Presensi Berhasil Dibuka");
                    window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
        } else {
            if (!isset($_SESSION['presensi_siap_simpan'])) {
                $_SESSION['presensi_siap_simpan'] = array();
            }

            $_SESSION['presensi_siap_simpan'][$id_pertemuan] = 1;

            echo '<script>alert("Presensi Berhasil Ditutup");
                    window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan.'";</script>';
        }
    }
}
?>