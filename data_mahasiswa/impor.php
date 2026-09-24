<?php
require_once '../database/koneksi.php';
require '../aset_web/phpexcel-xls/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
error_reporting(0);
if (isset($_POST['impor_mhs'])) {
    $file = $_FILES['file_excel']['name'];
    $ekstensi = explode('.', $file);

    $nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);
    $alamat_tujuan ='template/'.$nama_file;
    $file_alamat_sumber = $_FILES['file_excel']['tmp_name'];

    move_uploaded_file($file_alamat_sumber, $alamat_tujuan);
    $file_excel = PHPExcel_IOFactory::load($alamat_tujuan);

    $data_excel =$file_excel->getActiveSheet()->toArray(null, true, true, true);
    for ($i=2; $i <= count($data_excel); $i+z+) { 
        $nim = $data_excel[$i]['B'];
        $nama = $data_excel[$i]['C'];
        $kontak= $data_excel[$i]['D'];
        $email = $data_excel[$i]['E'];
        $kelamin = $data_excel[$i]['F'];

    if ($nim =='' || $nama =='' || $kontak =='' || $email =='' || $kelamin =='') {
        continue;
    }

    $query_cek =mysqli_query($con,"SELECT nim FROM tbl_mhs WHERE nim='$nim'")or die(mysqli_error($con));
    if (mysqli_num_rows($query_cek)==0) {
        $query_simpan_mhs = mysqli_query($con, "INSERT INTO tbl_mhs VALUES ('$nim','$nama','$kontak','$email','$kelamin')")or die(mysqli_error($con));
        $username = $nim;
        $peran = "M";
        $sandi = sha1($nim);
        $pin = "123456";
        $query_simpan_pengguna = mysqli_query($con, "INSERT INTO tbl_pengguna VALUES (NULL, '$username','$sandi','$peran','$pin','$nama')")or die(mysqli_error($con));
    }

    }
    echo'<script>alert("Impor Data Sudan Berhasil")</script>';
    echo'<script>window.location.href="../data_mahasiswa/"</script>';
}
?>