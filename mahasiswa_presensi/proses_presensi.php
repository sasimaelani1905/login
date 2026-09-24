<?php
require_once '../database/koneksi.php';

if (isset($_GET['id_pertemuan'])) {
    $id_pertemuan = @$_GET['id_pertemuan'];
    $nim = $_SESSION['username'];
    $query_ambil_status_pertemuan = mysqli_query($con, "SELECT status FROM tbl_pertemuan WHERE id_pertemuan='$id_pertemuan'")or die(mysqli_error($con));
    $data_pertemuan = mysqli_fetch_array($query_ambil_status_pertemuan);
    $status = $data_pertemuan['status'];

    if ($status == 0) {
        echo '<script> alert("Presensi telah ditutup anda tidak bisa melakukan presensi ini");
        window.location.href="../mahasiswa_presensi/presensi.php";
        </script>';
    }else{
        $query_status_kehadiran = mysqli_query($con, "SELECT status_kehadiran FROM tbl_presensi WHERE id_pertemuan='$id_pertemuan' AND nim='$nim'")or die(mysqli_error($con));
        $data_status_kehadiran = mysqli_fetch_array($query_status_kehadiran);
        $status_kehadiran = $data_status_kehadiran['status_kehadiran'];
        if ($status_kehadiran == 'hadir') {
            echo '<script> alert("Anda sudah melakukan presensi di pertemuan ini");
            window.location.href="../mahasiswa_presensi/presensi.php";
            </script>';
        }else{
            $status_hadir = 'hadir';
            $query_update_kehadiran = mysqli_query($con, "UPDATE tbl_presensi SET status_kehadiran ='$status_hadir' WHERE id_pertemuan='$id_pertemuan' AND nim='$nim'")or die(mysqli_error($con));
            echo 'alert("Anda berhasil melakukan presensi");
            ';
        }
    }
}
?>