<?php 
require_once '../database/koneksi.php';
$id = @$_GET['id'];

$hapus_pengguna = mysqli_query($con, "DELETE FROM tbl_kelas_matkul 
WHERE id = '$id'")or die (mysqli_error($con));

echo '<script>alert("Data Kelas Matkul'.$id.' Berhasil Dihapus");
window.location.href="../admin_data_kelas_matkul"
</script>';

?>