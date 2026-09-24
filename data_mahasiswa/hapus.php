<?php
    require_once('../database/koneksi.php');
    $pengguna_login_mhs  = $_SESSION['nim'];
    $pengguna = @$_GET['nim'];
    $cek_mhs = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM tbl_mhs WHERE nim = '$pengguna'")or die(mysqli_error($con));
    $data = mysqli_fetch_assoc($cek_mhs);
    $jumlah = $data['jumlah'];

    if ($pengguna_login_mhs == $pengguna && $jumlah == 1) {
        echo '<script> alert ("Anda yakin??");
        window.location.href="../data_mahasiswa"
        </script>';

    }elseif($pengguna_login_mhs != $pengguna && $jumlah == 0){
    $hapus_pengguna = mysqli_query($con, "DELETE FROM tbl_mhs WHERE nim='$pengguna'")or die(mysqli_error($con));
    echo '<script> alert ("Data Mahasiswa '.$pengguna.' Berhasil Dihapus");
    window.location.href="../data_mahasiswa"
    </script>';

    }else{
    $hapus_pengguna =mysqli_query($con, "DELETE FROM tbl_mhs WHERE nim='$pengguna'")or die(mysqli_error($con));
    echo '<script> alert ("Data Mahasiswa '.$pengguna.' Berhasil Dihapus");
    window.location.href="../data_mahasiswa"
    </script>';
    }
 ?>
        