<?php
require_once '../database/koneksi.php';

if (isset($_POST['edit_jurusan'])) {

    $kode_jurusan  = trim(mysqli_real_escape_string($con, $_POST['kode_jurusan']) );
    $nama_jurusan  = trim(mysqli_real_escape_string($con, $_POST['nama_jurusan']) );

    $query_edit = mysqli_query($con,"UPDATE tbl_jurusan SET nama_jurusan = '$nama_jurusan' WHERE kode_jurusan = '$kode_jurusan'")or die(mysqli_error($con));

    echo '<script> alert ("Data Berhasil Diedit");
    window.location.href = "../admin_data_jurusan"</script>';
    
}
?>