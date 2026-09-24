<?php
require_once '../database/koneksi.php';

if (isset($_POST['edit_dosen'])) {

    $nik  = trim(mysqli_real_escape_string($con, $_POST['nik']) );
    $nama  = trim(mysqli_real_escape_string($con, $_POST['nama']) );
    $kontak  = trim(mysqli_real_escape_string($con, $_POST['kontak']) );
    $email  = trim(mysqli_real_escape_string($con, $_POST['email']) );
    $kelamin  = trim(mysqli_real_escape_string($con, $_POST['kelamin']) );

    $query_edit = mysqli_query($con,"UPDATE tbl_dosen SET
    nik = '$nik',
    nama = '$nama',
    kontak = '$kontak',
    email = '$email',
    kelamin = '$kelamin' WHERE nik = '$nik'
     ")or die(mysqli_error($con));

    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../data_dosen"</script>';
    
}
?>