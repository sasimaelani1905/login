<?php
require_once '../database/koneksi.php';
require '../aset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
error_reporting(0);
if (isset($_POST['btn_impor'])) {
    $file = $_FILES['file_excel']['name'];
    $ekstensi = explode('.', $file);

    $nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);
    $alamat_tujuan ='template/'.$nama_file;
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];

    move_uploaded_file($file_alamat_sumber, $alamat_tujuan);
    $file_excel = PHPExcel_IOFactory::load($alamat_tujuan);

    $data_excel =$file_excel->getActiveSheet()->toArray(null, true, true, true);
    for ($i=2; $i <= count($data_excel); $i++) { 
        $kode_matkul = $data_excel[$i]['B'];
        $nama_matkul = $data_excel[$i]['C'];
        $jml_sks = $data_excel[$i]['D'];
        $jml_cpmk = $data_excel[$i]['E'];

    if ($kode_matkul =='' || $nama_matkul =='' || $jml_sks =='' || $jml_cpmk =='') {
        continue;
    }

    $query_cek =mysqli_query($con,"SELECT kode_matkul FROM tbl_matkul WHERE kode_matkul='$kode_matkul'")or die(mysqli_error($con));
    if (mysqli_num_rows($query_cek)==0) {
        $query_insert = mysqli_query($con, "INSERT INTO tbl_matkul VALUES ('$kode_matkul','$nama_matkul','$jml_sks','$jml_cpmk')")or die(mysqli_error($con));
    }

    }
    echo'<script>alert("Impor Data Sudan Berhasil")</script>';
    echo'<script>window.location.href="../admin_mata_kuliah/"</script>';
}
?>