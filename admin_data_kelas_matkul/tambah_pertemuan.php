<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
    $kode_kelas = $_POST['id'];
    $judul_pertemuan = $_POST['judul_pertemuan'];
    
    // Otomatis mengambil tanggal hari ini (Format: YYYY-MM-DD)
    $tanggal = date('Y-m-d');

    // 1. Cari pertemuan terakhir
    $panggil_pertemuan = mysqli_query($con, "SELECT MAX(pertemuan_ke) AS pertemuan FROM tbl_pertemuan WHERE id='$kode_kelas'") or die(mysqli_error($con));
    $data_pertemuan = mysqli_fetch_array($panggil_pertemuan);
    $pertemuan_terakhir = $data_pertemuan['pertemuan'];

    // 2. Tentukan urutan pertemuan berikutnya
    if ($pertemuan_terakhir < 1) {
        $pertemuan_ke = 1;
    } else {
        $pertemuan_ke = $pertemuan_terakhir + 1;
    }

    $status_pertemuan = '1';

    // 3. Simpan data pertemuan
    $simpan_pertemuan = mysqli_query($con, "INSERT INTO tbl_pertemuan (id, tanggal, judul_pertemuan, status, pertemuan_ke) VALUES ('$kode_kelas', '$tanggal', '$judul_pertemuan', '$status_pertemuan', '$pertemuan_ke')") or die(mysqli_error($con));
    
    $id_pertemuan = mysqli_insert_id($con);

    // 4. Ambil daftar mahasiswa / peserta kelas
    $ambil_peserta = mysqli_query($con, "SELECT nim FROM tbl_detail_kelas_matkul WHERE id = '$kode_kelas'") or die(mysqli_error($con));

    if (mysqli_num_rows($ambil_peserta) > 0) {
        $status_kehadiran = 'alfa';
        while ($data_peserta = mysqli_fetch_array($ambil_peserta)) {
            $nim = $data_peserta['nim'];
            $simpan_peserta = mysqli_query($con, "INSERT INTO tbl_presensi (id_pertemuan, nim, status_kehadiran) VALUES ('$id_pertemuan', '$nim', '$status_kehadiran')") or die(mysqli_error($con));
        }
    }

    // 5. Alert & Redirect
    echo '<script>alert("Presensi Pertemuan Ke '.$pertemuan_ke.' Berhasil Dibuat");
    window.location.href = "../admin_data_kelas_matkul/presensi.php?id_pertemuan='.$id_pertemuan.'";</script>';
}
?>