<?php
require_once '../database/koneksi.php';
require('../aset_web/fpdf/fpdf.php');

$kode_kelas = $_GET['id'] ?? '';
if (empty($kode_kelas)) {
    die("ID Kelas tidak valid.");
}

$panggil_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE id = '$kode_kelas'") or die(mysqli_error($con));
$data_kelas    = mysqli_fetch_array($panggil_kelas);
if (!$data_kelas) {
    die("Data kelas tidak ditemukan.");
}

$kode_akd     = $data_kelas['kode_akd'];
$kode_matkul  = $data_kelas['kode_matkul'];
$kode_jurusan = $data_kelas['kode_jurusan'];
$nik          = $data_kelas['nik'];
$nama_kelas   = $data_kelas['nama_kelas'];

$query_akademik = mysqli_query($con, "SELECT tahun, semester FROM tbl_akademik WHERE kode_akd = '$kode_akd'") or die(mysqli_error($con));
$data_akademik  = mysqli_fetch_array($query_akademik);
$periode_text   = ($data_akademik) ? $data_akademik['tahun'] . ' - ' . ($data_akademik['semester'] == 'GN' ? 'Genap' : 'Ganjil') : '-';

$query_dosen = mysqli_query($con, "SELECT nama FROM tbl_dosen WHERE nik = '$nik'") or die(mysqli_error($con));
$data_dosen  = mysqli_fetch_array($query_dosen);
$dosen_text  = ($data_dosen) ? $data_dosen['nama'] : '-';

$query_matkul = mysqli_query($con, "SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($con));
$data_matkul  = mysqli_fetch_array($query_matkul);
$matkul_text  = ($data_matkul) ? $data_matkul['nama_matkul'] : '-';

$query_jurusan = mysqli_query($con, "SELECT nama_jurusan FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan'") or die(mysqli_error($con));
$data_jurusan  = mysqli_fetch_array($query_jurusan);
$jurusan_text  = ($data_jurusan) ? $data_jurusan['nama_jurusan'] : '-';

class PDF extends FPDF
{
    function Header()
    {
        if (file_exists('../aset_web/img/logo.png')) {
            $this->Image('../aset_web/img/logo.png', 15, 7, 40);
        }
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, 'UNIVERSITAS PERADABAN', 0, 1, 'C');
        $this->Cell(0, 5, 'FAKULTAS SAINS DAN TEKNOLOGI', 0, 1, 'C');
        $this->Cell(0, 5, 'PRODI INFORMATIKA', 0, 1, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, 'Jl. Raya Pagojengan KM 3, Kecamatan Paguyangan, Kabupaten Brebes, Jawa Tengah 52276', 0, 1, 'C');
        $this->Cell(0, 4, 'HP: 082324650425 | Email: universitasperadaban.ac.id', 0, 1, 'C');
        $this->SetLineWidth(0.8);
        $this->Line(15, 34, 200, 34);
        $this->Ln(6);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 7, 'LAPORAN PRESENSI', 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(38, 5, 'PERIODE AKADEMIK', 0, 0, 'L');
$pdf->Cell(3, 5, ':', 0, 0, 'C');
$pdf->Cell(50, 5, $periode_text, 0, 0, 'L');
$pdf->Cell(30, 5, 'DOSEN', 0, 0, 'L');
$pdf->Cell(3, 5, ':', 0, 0, 'C');
$pdf->Cell(60, 5, $dosen_text, 0, 1, 'L');
$pdf->Cell(38, 5, 'NAMA KELAS', 0, 0, 'L');
$pdf->Cell(3, 5, ':', 0, 0, 'C');
$pdf->Cell(50, 5, $nama_kelas, 0, 0, 'L');
$pdf->Cell(30, 5, 'MATA KULIAH', 0, 0, 'L');
$pdf->Cell(3, 5, ':', 0, 0, 'C');
$pdf->Cell(60, 5, $matkul_text, 0, 1, 'L');
$pdf->Cell(38, 5, 'JURUSAN', 0, 0, 'L');
$pdf->Cell(3, 5, ':', 0, 0, 'C');
$pdf->Cell(50, 5, $jurusan_text, 0, 1, 'L');
$pdf->Ln(6);

$query_pertemuan = mysqli_query($con, "SELECT * FROM tbl_pertemuan WHERE id = '$kode_kelas' ORDER BY pertemuan_ke ASC") or die(mysqli_error($con));
if (mysqli_num_rows($query_pertemuan) > 0) {
    while ($pertemuan = mysqli_fetch_array($query_pertemuan)) {
        $id_pertemuan    = $pertemuan['id_pertemuan'];
        $pertemuan_ke    = $pertemuan['pertemuan_ke'];
        $judul_pertemuan = $pertemuan['judul_pertemuan'];
        $tanggal         = $pertemuan['tanggal'];

        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(0, 6, 'Pertemuan Ke-' . $pertemuan_ke . ' : ' . $judul_pertemuan . ' (' . date('d-m-Y', strtotime($tanggal)) . ')', 0, 1, 'L');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(12, 7, 'No', 1, 0, 'C');
        $pdf->Cell(35, 7, 'NIM', 1, 0, 'C');
        $pdf->Cell(93, 7, 'Nama Mahasiswa', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Status Kehadiran', 1, 1, 'C');

        $query_presensi = mysqli_query($con, "SELECT * FROM tbl_presensi WHERE id_pertemuan = '$id_pertemuan'") or die(mysqli_error($con));

        $pdf->SetFont('Times', '', 10);
        if (mysqli_num_rows($query_presensi) > 0) {
            $no = 1;
            while ($presensi = mysqli_fetch_array($query_presensi)) {
                $nim = $presensi['nim'];

                $query_mhs = mysqli_query($con, "SELECT nama FROM tbl_mhs WHERE nim = '$nim'") or die(mysqli_error($con));
                $data_mhs  = mysqli_fetch_array($query_mhs);
                $nama_mhs  = ($data_mhs) ? $data_mhs['nama'] : '-';

                $pdf->Cell(12, 6, $no++, 1, 0, 'C');
                $pdf->Cell(35, 6, $nim, 1, 0, 'C');
                $pdf->Cell(93, 6, ' ' . $nama_mhs, 1, 0, 'L');
                $pdf->Cell(50, 6, ucfirst($presensi['status_kehadiran']), 1, 1, 'C');
            }
        } else {
            $pdf->Cell(190, 6, 'Belum ada data presensi pada pertemuan ini.', 1, 1, 'C');
        }
        $pdf->Ln(5); 
    }
} else {
    $pdf->SetFont('Times', 'I', 10);
    $pdf->Cell(0, 7, 'Belum ada pertemuan yang dibuat untuk kelas ini.', 0, 1, 'C');
}
$pdf->Output('I', 'Laporan_Presensi_Per_Pertemuan_'.$kode_kelas.'.pdf');
?>