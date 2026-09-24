<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {

    $kode_kelas  = trim(mysqli_real_escape_string($con, $_POST['id']) );
    $nim  = trim(mysqli_real_escape_string($con, $_POST['nim']) );

    $cek_kelas = mysqli_query($con, "SELECT * FROM tbl_detail_kelas_matkul WHERE id = '$kode_kelas' AND nim = '$nim'")or die(mysqli_error($con));
    $kelas = mysqli_num_rows($cek_kelas);

    if ($kelas > 0) {
        echo '<script>alert("Data Sudah Ada");
        window.location.href = "../detail_kelas_matkul"</script>';
    }else {
    $query_simpan_matkul = mysqli_query($con,"INSERT INTO tbl_detail_kelas_matkul VALUES (null,'$kode_kelas','$nim') ")or die(mysqli_error($con));
    echo '<script> alert ("Data Berhasil Disimpan");
    window.location.href = "../detail_kelas_matkul/?id='.$kode_kelas.'";</script>';
    }  
    }
?>