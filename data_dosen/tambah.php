<?php
require_once ('../database/koneksi.php');

if (isset($_POST['tambah_dosen'])) {
    $nik        = trim(mysqli_real_escape_string($con, $_POST['nik']));
    $nama       = trim(mysqli_real_escape_string($con, $_POST['nama']));
    $kontak     = trim(mysqli_real_escape_string($con, $_POST['kontak']));
    $email      = trim(mysqli_real_escape_string($con, $_POST['email']));
    $kelamin    = trim(mysqli_real_escape_string($con, $_POST['kelamin']));

    $query_cek_nik = mysqli_query($con, "SELECT nik FROM tbl_dosen WHERE nik ='$nik' ")
    or die(mysqli_error($con));
    $rv = mysqli_num_rows($query_cek_nik);
    $cek_user = mysqli_query ($con, "SELECT username FROM tbl_pengguna WHERE username = '$nik'")or die (mysqli_error($con));
    $rv = mysqli_num_rows($cek_user);
    if ($rv > 0) {
        echo '<script> alert ("Data Sudah Terdaftar! Input yang lain");
        window.location.href="../data_dosen/"</script>';
    } else {
        $query_simpan = mysqli_query ($con, "INSERT INTO tbl_dosen VALUES('$nik', '$nama', '$kontak', '$email', '$kelamin')")or die(mysqli_error($con));
        $peran = "D";
        $username = $nik;
        $sandi = sha1($nik);
        $pin = "696969";
        $query_simpan_pengguna = mysqli_query ($con, "INSERT INTO tbl_pengguna VALUES (NULL, '$username', '$sandi', '$peran', '$pin', '$nama')")or die (mysqli_error($con));
        echo '<script> alert ("Data dosen Ditambah"); 
        window.location.href="../data_dosen" </script>';
    }
}
?>
