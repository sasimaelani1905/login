<?php
require_once ('../database/koneksi.php');

if (isset($_POST['tambah_mahasiswa'])) {
    $nim        = trim(mysqli_real_escape_string($con, $_POST['nim']));
    $nama       = trim(mysqli_real_escape_string($con, $_POST['nama']));
    $kontak     = trim(mysqli_real_escape_string($con, $_POST['kontak']));
    $email      = trim(mysqli_real_escape_string($con, $_POST['email']));
    $kelamin    = trim(mysqli_real_escape_string($con, $_POST['kelamin']));

    $query_cek_nim = mysqli_query($con, "SELECT nim FROM tbl_mhs WHERE nim ='$nim' ")
    or die(mysqli_error($con));
    $rv = mysqli_num_rows($query_cek_nim);
    $cek_user = mysqli_query ($con, "SELECT username FROM tbl_pengguna WHERE username = '$nim'")or die (mysqli_error($con));
    $rv = mysqli_num_rows($cek_user);
    if ($rv > 0) {
        echo '<script> alert ("Data Sudah Terdaftar! Input yang lain");
        window.location.href="../data_mahasiswa/"</script>';
    } else {
        $query_simpan = mysqli_query ($con, "INSERT INTO tbl_mhs VALUES('$nim', '$nama', '$kontak', '$email', '$kelamin')")or die(mysqli_error($con));
        $peran = "M";
        $sandi = sha1($nim);
        $pin = "123456";
        $query_simpan_pengguna = mysqli_query ($con, "INSERT INTO tbl_pengguna VALUES (NULL, '$nim', '$sandi', '$peran', '$pin', '$nama')")or die (mysqli_error($con));
        echo '<script> alert ("Data Mahasiswa Ditambah"); 
        window.location.href="../data_mahasiswa" </script>';
    }
}
?>
