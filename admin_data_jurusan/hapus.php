<?php 
require_once '../database/koneksi.php';
$jurusan = @$_GET['kode_jurusan'];

$hapus_pengguna = mysqli_query($con, "DELETE FROM tbl_jurusan 
WHERE kode_jurusan = '$jurusan'")or die (mysqli_error($con));

echo '<script>alert("Data jurusan '.$jurusan.' Berhasil Dihapus");
window.location.href="../admin_data_jurusan"
</script>';

?>