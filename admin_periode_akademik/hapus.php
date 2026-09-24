<?php 
require_once '../database/koneksi.php';
$akd = @$_GET['kode_akd'];

$hapus_pengguna = mysqli_query($con, "DELETE FROM tbl_akademik 
WHERE kode_akd = '$akd'")or die (mysqli_error($con));

echo '<script>alert("Data Akademik '.$akd.' Berhasil Dihapus");
window.location.href="../admin_periode_akademik"
</script>';

?>