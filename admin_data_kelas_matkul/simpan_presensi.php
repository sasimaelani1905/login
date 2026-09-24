<?php
require_once '../database/koneksi.php';

if (isset($_GET['id_pertemuan'])) {
    $id_pertemuan = trim(mysqli_real_escape_string($con, $_GET['id_pertemuan']));
    if (!isset($_SESSION['presensi_siap_simpan'][$id_pertemuan]) || $_SESSION['presensi_siap_simpan'][$id_pertemuan] != 1) {
        echo '<script>alert("Presensi belum selesai ditutup.");
                window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
        exit;
    }

    $query_pertemuan = mysqli_query($con, "SELECT * FROM tbl_pertemuan WHERE id_pertemuan='$id_pertemuan'") or die(mysqli_error($con));
    $data_pertemuan = mysqli_fetch_array($query_pertemuan);
    if (!$data_pertemuan) {
        echo '<script>alert("Data pertemuan tidak ditemukan.");
                window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
        exit;
    }

    $kode_kelas = $data_pertemuan['id'];
    $query_mahasiswa = mysqli_query($con, "SELECT nim FROM tbl_detail_kelas_matkul WHERE id='$kode_kelas'") or die(mysqli_error($con));
    $berhasil = true;

    while ($data_mahasiswa = mysqli_fetch_array($query_mahasiswa)) {
        $nim = $data_mahasiswa['nim'];
        if (isset($_SESSION['presensi_edit'][$id_pertemuan][$nim]) && !empty($_SESSION['presensi_edit'][$id_pertemuan][$nim])) {

            $status_kehadiran = $_SESSION['presensi_edit'][$id_pertemuan][$nim];$status_kehadiran = mysqli_real_escape_string($con, $status_kehadiran);
            $cek_presensi = mysqli_query($con, "SELECT id_presensi FROM tbl_presensi WHERE id_pertemuan='$id_pertemuan' AND nim='$nim'") or die(mysqli_error($con));

            if (mysqli_num_rows($cek_presensi) > 0) {
                $query_simpan = mysqli_query($con, "UPDATE tbl_presensi SET status_kehadiran='$status_kehadiran' WHERE id_pertemuan='$id_pertemuan' AND nim='$nim'") or die(mysqli_error($con));
            } else {
                $query_simpan = mysqli_query($con, "INSERT INTO tbl_presensi (id_pertemuan, nim, status_kehadiran VALUES ('$id_pertemuan', '$nim', '$status_kehadiran')") or die(mysqli_error($con));
            }
            if (!$query_simpan) {
                $berhasil = false;
            }
        }
    }

    if ($berhasil) {
        unset($_SESSION['presensi_edit'][$id_pertemuan]);

        unset($_SESSION['presensi_siap_simpan'][$id_pertemuan]);
        echo '<script>alert("Data Presensi Berhasil Disimpan");
                window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
    } else {
        echo '<script>alert("Data Presensi Gagal Disimpan");
                window.location.href="presensi.php?id_pertemuan=' . $id_pertemuan . '";</script>';
    }
}
?>