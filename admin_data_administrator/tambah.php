<?php
require_once ('../database/koneksi.php');

if (isset($_POST['tambah'])) {
    $username   = trim(mysqli_real_escape_string($con, $_POST['username']));
    $nama       = trim(mysqli_real_escape_string($con, $_POST['nama']));
    $peran      = trim(mysqli_real_escape_string($con, $_POST['peran']));
    // $pin        = trim(mysqli_real_escape_string($con, $_POST['pin']));
    $pin        = "696969";
    $password   = sha1($username);

    $cek_user = mysqli_query($con, "SELECT username FROM tbl_pengguna")or die(mysqli_error($con));
    $rv = mysqli_num_rows($cek_user);

    if ($rv == 1) {
        echo '<script> alert ("Data Sudah Terdaftar! Input yang lain");
        window.location.href="../admin_data_administrator/"</script>';
    }else {
        $query_simpan = mysqli_query ($con, "INSERT INTO tbl_pengguna 
        (username, sandi, peran, pin, nama) 
        VALUES 
        ('$username', '$password', '$peran', '$pin', '$nama')")or die(mysqli_error($con));

        echo '<script> alert ("Data Berhasil Disimpan"); 
        window.location.href="../admin_data_administrator" </script>';
    }
}
?>