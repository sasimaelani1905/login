<?php
require_once '../database/koneksi.php';
require '../aset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['impor_dosen'])) {
    $file = $_FILES['file_excel']['name'];
    $ekstensi = pathinfo($file, PATHINFO_EXTENSION);
    $nama_file ='file_'.time().'.'.$ekstensi;
    $folder_tujuan = 'template/';

    if (!file_exists($folder_tujuan)) {
        mkdir($folder_tujuan, 0777, true);
    }

    $alamat_tujuan = $folder_tujuan . $nama_file;
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];

    if (move_uploaded_file($file_alamat_sumber, $alamat_tujuan)) {
        $file_excel = PHPExcel_IOFactory::load($alamat_tujuan);
        $data_excel = $file_excel->getActiveSheet()->toArray(null, false, true, true);

        foreach ($data_excel as $index => $row) {
            if ($index == 1) continue;
                $nik     = trim((string)$row['B']);
                $nama    = trim((string)$row['C']);
                $kontak  = trim((string)$row['D']);
                $email   = trim((string)$row['E']);
                $kelamin = trim((string)$row['F']);
            if (empty($nik) || empty($nama)) {
                continue;
            }

            $query_cek = mysqli_query($con, "SELECT nik FROM tbl_dosen WHERE nik='$nik'") or die(mysqli_error($con));
            if (mysqli_num_rows($query_cek) == 0) {
                $query_simpan_dosen = mysqli_query($con, "INSERT INTO tbl_dosen (nik, nama, kontak, email, kelamin) VALUES ('$nik', '$nama', '$kontak', '$email', '$kelamin')") or die(mysqli_error($con));
                $username = $nik;
                $peran    = "D";
                $sandi    = sha1($nik);
                $pin      = "696969";
                $query_simpan_pengguna = mysqli_query($con, "INSERT INTO tbl_pengguna (username, sandi, peran, pin, nama) VALUES ('$username', '$sandi', '$peran', '$pin', '$nama')") or die(mysqli_error($con));
            }
        }
        if (file_exists($alamat_tujuan)) {
            unlink($alamat_tujuan);
        }
        echo '<script>alert("Impor Data Sudah Berhasil");</script>';
        echo '<script>window.location.href="../data_dosen/";</script>';
    } else {
        echo '<script>alert("Gagal mengunggah file. Cek izin folder template.");</script>';
    }
}
?>