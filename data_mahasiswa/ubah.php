<?php
require_once '../database/koneksi.php';

if (isset($_POST['edit_mahasiswa'])) {

    $nim  = trim(mysqli_real_escape_string($con, $_POST['nim']) );
    $nama  = trim(mysqli_real_escape_string($con, $_POST['nama']) );
    $kontak  = trim(mysqli_real_escape_string($con, $_POST['kontak']) );
    $email  = trim(mysqli_real_escape_string($con, $_POST['email']) );
    $kelamin  = trim(mysqli_real_escape_string($con, $_POST['kelamin']) );

    $query_edit = mysqli_query($con,"UPDATE tbl_mhs SET
    nim = '$nim',
    nama = '$nama',
    kontak = '$kontak',
    email = '$email',
    kelamin = '$kelamin' WHERE nim = '$nim'
     ")or die(mysqli_error($con));

    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../data_mahasiswa"</script>';
    
}
?>