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

$id_pertemuan_list = [];
$query_pertemuan = mysqli_query($con, "SELECT id_pertemuan FROM tbl_pertemuan WHERE id = '$kode_kelas'") or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($query_pertemuan)) {
    $id_pertemuan_list[] = "'" . mysqli_real_escape_string($con, $row['id_pertemuan']) . "'";
}

$total_pertemuan = count($id_pertemuan_list);

class PDF extends FPDF
{
    function Header()
    {
        if (file_exists('../aset_web/img/logo.png')) {
            $this->Image('../aset_web/img/logo.png', 15, 7, 30);
        }
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, 'UNIVERSITAS PERADABAN', 0, 1, 'C');
        $this->Cell(0, 5, 'FAKULTAS SAINS DAN TEKNOLOGI', 0, 1, 'C');
        $this->Cell(0, 5, 'PRODI INFORMATIKA', 0, 1, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, 'Jl. Raya Pagojengan KM 3, Kecamatan Paguyangan, Kabupaten Brebes, Jawa Tengah 52276', 0, 1, 'C');
        $this->Cell(0, 4, 'HP: 082324650425 | Email: universitasperadaban.ac.id', 0, 1, 'C');
        $this->SetLineWidth(0.8);
        $this->Line(15, 34, 195, 34);
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
$pdf->Cell(0, 7, 'REKAPITULASI PRESENSI MAHASISWA', 0, 1, 'C');
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

$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(25, 8, 'NIM', 1, 0, 'C');
$pdf->Cell(60, 8, 'Nama Mahasiswa', 1, 0, 'C');
$pdf->Cell(12, 8, 'Hadir', 1, 0, 'C');
$pdf->Cell(12, 8, 'Izin', 1, 0, 'C');
$pdf->Cell(12, 8, 'Sakit', 1, 0, 'C');
$pdf->Cell(12, 8, 'Alpa', 1, 0, 'C');
$pdf->Cell(22, 8, 'Kehadiran (%)', 1, 0, 'C');
$pdf->Cell(20, 8, 'Nilai (15%)', 1, 1, 'C');

$pdf->SetFont('Times', '', 9);

$bobot_hadir = 1.0;  // 100%
$bobot_izin  = 0.0;  // 0%
$bobot_sakit = 0.0;  // 0%
$bobot_alpa  = 0.0;  // 0%

if (!empty($id_pertemuan_list)) {
    $string_id_pertemuan = implode(',', $id_pertemuan_list);

    $nim_list = [];
    $query_nim = mysqli_query($con, "SELECT DISTINCT nim FROM tbl_presensi WHERE id_pertemuan IN ($string_id_pertemuan) ORDER BY nim ASC") or die(mysqli_error($con));
    
    while ($row_nim = mysqli_fetch_assoc($query_nim)) {
        $nim_list[] = $row_nim['nim'];
    }

    if (!empty($nim_list)) {
        $no = 1;
        foreach ($nim_list as $nim) {
            $query_mhs = mysqli_query($con, "SELECT nama FROM tbl_mhs WHERE nim = '$nim'") or die(mysqli_error($con));
            $data_mhs  = mysqli_fetch_array($query_mhs);
            $nama_mhs  = ($data_mhs) ? $data_mhs['nama'] : '-';

            $q_stat = mysqli_query($con, "
                SELECT 
                    SUM(CASE WHEN LOWER(status_kehadiran) = 'hadir' THEN 1 ELSE 0 END) AS jml_hadir,
                    SUM(CASE WHEN LOWER(status_kehadiran) = 'izin' THEN 1 ELSE 0 END) AS jml_izin,
                    SUM(CASE WHEN LOWER(status_kehadiran) = 'sakit' THEN 1 ELSE 0 END) AS jml_sakit,
                    SUM(CASE WHEN LOWER(status_kehadiran) = 'alpa' THEN 1 ELSE 0 END) AS jml_alpa
                FROM tbl_presensi 
                WHERE id_pertemuan IN ($string_id_pertemuan) AND nim = '$nim'
            ") or die(mysqli_error($con));

            $stat = mysqli_fetch_array($q_stat);

            $hadir = (int) ($stat['jml_hadir'] ?? 0);
            $izin  = (int) ($stat['jml_izin'] ?? 0);
            $sakit = (int) ($stat['jml_sakit'] ?? 0);
            $alpa  = (int) ($stat['jml_alpa'] ?? 0);

            $skor_kehadiran = ($hadir * $bobot_hadir) + ($izin * $bobot_izin) + ($sakit * $bobot_sakit) + ($alpa * $bobot_alpa);

            $persentase = ($total_pertemuan > 0) ? ($skor_kehadiran / $total_pertemuan) * 100 : 0;

            $nilai_15 = ($persentase / 100) * 15;

            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(25, 6, $nim, 1, 0, 'C');
            $pdf->Cell(60, 6, ' ' . $nama_mhs, 1, 0, 'L');
            $pdf->Cell(12, 6, $hadir, 1, 0, 'C');
            $pdf->Cell(12, 6, $izin, 1, 0, 'C');
            $pdf->Cell(12, 6, $sakit, 1, 0, 'C');
            $pdf->Cell(12, 6, $alpa, 1, 0, 'C');
            $pdf->Cell(22, 6, number_format($persentase, 1) . '%', 1, 0, 'C');
            $pdf->Cell(20, 6, number_format($nilai_15, 2), 1, 1, 'C');
        }
    } else {
        $pdf->Cell(190, 7, 'Belum ada data presensi mahasiswa untuk kelas ini.', 1, 1, 'C');
    }
} else {
    $pdf->Cell(190, 7, 'Belum ada pertemuan yang dibuat untuk kelas ini.', 1, 1, 'C');
}

$pdf->Output('I', 'Rekap_Presensi_Kelas_'.$kode_kelas.'.pdf');
?>