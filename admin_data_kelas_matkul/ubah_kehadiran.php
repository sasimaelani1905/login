<?php
session_start();
require_once '../database/koneksi.php';

if (isset($_POST['btn_ubah_kehadiran'])) {

    $id_pertemuan = isset($_POST['id_pertemuan']) ? trim(mysqli_real_escape_string($con, $_POST['id_pertemuan'])) : '';
    $nim          = isset($_POST['nim']) ? trim(mysqli_real_escape_string($con, $_POST['nim'])) : '';
    $status       = isset($_POST['status_kehadiran']) ? trim(mysqli_real_escape_string($con, $_POST['status_kehadiran'])) : '';

    if (empty($nim)) {
        echo '<script>alert("NIM tidak ditemukan!");
                window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
        exit;
    }

    $cek_pertemuan = mysqli_query($con, "SELECT status FROM tbl_pertemuan WHERE id_pertemuan='$id_pertemuan'") or die(mysqli_error($con));
    $data_pertemuan = mysqli_fetch_array($cek_pertemuan);

    if (!$data_pertemuan) {
        echo '<script>alert("Data pertemuan tidak ditemukan");
                window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
        exit;
    }

    if ($data_pertemuan['status'] != '0') {
        echo '<script>alert("Presensi sudah ditutup, data tidak dapat diedit");
                window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
        exit;
    }

    if (!isset($_SESSION['presensi_edit'])) {
        $_SESSION['presensi_edit'] = array();
    }

    if (!isset($_SESSION['presensi_edit'][$id_pertemuan])) {
        $_SESSION['presensi_edit'][$id_pertemuan] = array();
    }

    $_SESSION['presensi_edit'][$id_pertemuan][$nim] = $status;

    echo '<script>alert("Status Kehadiran Berhasil Diubah");
            window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
}
?>