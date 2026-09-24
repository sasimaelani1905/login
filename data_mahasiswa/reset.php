<?php 
require_once '../database/koneksi.php';
$query_reset = mysqli_query($con,"TRUNCATE TABLE tbl_mhs")or die (mysqli_error($con));

echo '<script>alert("Data Dosen Berhasil Direset");
window.location.href="../data_mahasiswa"
</script>';

?>