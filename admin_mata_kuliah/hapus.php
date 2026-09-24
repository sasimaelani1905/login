<?php 
require_once '../database/koneksi.php';
$matkul = @$_GET['kode_matkul'];

$hapus_pengguna = mysqli_query($con, "DELETE FROM tbl_matkul 
WHERE kode_matkul = '$matkul'")or die (mysqli_error($con));

echo '<script>alert("Data matkul '.$matkul.' Berhasil Dihapus");
window.location.href="../admin_mata_kuliah"
</script>';

?>