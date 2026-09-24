<?php 
require_once '../database/koneksi.php';
$query_reset = mysqli_query($con,"TRUNCATE TABLE tbl_jurusan")or die (mysqli_error($con));

echo '<script>alert("Data Mata Kuliah Berhasil Direset");
window.location.href="../admin_data_jurusan"
</script>';

?>