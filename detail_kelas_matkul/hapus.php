<?php 
require_once '../database/koneksi.php';
$nim = @$_GET['nim'];

$hapus_pengguna = mysqli_query($con, "DELETE FROM tbl_detail_kelas_matkul 
WHERE nim = '$nim'")or die (mysqli_error($con));

echo '<script>alert("Data Mahsiswa '.$nim.' Berhasil Dihapus");
window.location.href="../detail_kelas_matkul";
</script>';

?>