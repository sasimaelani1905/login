<?php 
    require_once('../database/koneksi.php');
    $pengguna_login_dosen  = $_SESSION['nik'];
    $pengguna = @$_GET['nik'];
    $cek_dosen = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM tbl_dosen WHERE kelamin = 'P'")or die(mysqli_error($con));
    $data = mysqli_fetch_assoc($cek_dosen);
    $jumlah = $data['jumlah'];

    if ($pengguna_login_dosen == $pengguna && $jumlah == 1) {
        echo '<script> alert ("Anda yakin??");
        window.location.href="../data_dosen"</script>';

    }elseif($pengguna_login_dosen !=$pengguna && $jumlah ==0){
    $hapus_pengguna =mysqli_query($con, "DELETE FROM tbl_dosen WHERE nik='$pengguna'")or die(mysqli_error($con));
    echo '<script> alert ("Data Pengguna '.$pengguna.' Berhasil Dihapus");
    window.location.href="../data_dosen"</script>';

    }else{
    $hapus_pengguna =mysqli_query($con, "DELETE FROM tbl_dosen WHERE nik='$pengguna'")or die(mysqli_error($con));
    $hapus_simpan_pengguna = mysqli_query($con, "INSERT INTO tbl_pengguna VALUES (NULL, '$username','$sandi','$peran','$pin','$nama')")or die(mysqli_error($con));    
    echo '<script> alert ("Data Pengguna '.$pengguna.' Berhasil Dihapus");
    window.location.href="../data_dosen"</script>';
    }
?>