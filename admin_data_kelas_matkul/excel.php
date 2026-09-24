<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file ="Data-Kelas-Matkul-" . date('Y-m-d');

$query_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul")or die(mysqli_error($con));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Kelas Matkul');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'ID');
$sheet->setCellValue('C1', 'KODE AKD');
$sheet->setCellValue('D1', 'KODE MATKUL');
$sheet->setCellValue('E1', 'KODE JURUSAN');
$sheet->setCellValue('F1', 'NIK');
$sheet->setCellValue('G1', 'NAMA KELAS');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:G1')->applyFromArray($styleArray);
$sheet->getStyle('A1:G1')->getFont()->setBold(true);

foreach (array('B', 'C', 'D', 'E', 'F', 'G') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_kelas)){;
    $id = $data['id'];
    $kode_akd = $data['kode_akd'];
    $kode_matkul = $data['kode_matkul'];
    $kode_jurusan = $data['kode_jurusan'];
    $nik = $data['nik'];
    $nama_kelas = $data['nama_kelas'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $id);
    $sheet->setCellValue("C" . $rowNumber, $kode_akd);
    $sheet->setCellValue("D" . $rowNumber, $kode_matkul);
    $sheet->setCellValue("E" . $rowNumber, $kode_jurusan);
    $sheet->setCellValue("F" . $rowNumber, $nik);
    $sheet->setCellValue("G" . $rowNumber, $nama_kelas);
    $rowNumber++;
    $no++;
}

// Buat file excel
$filename = $nama_file . ".xlsx";
$writer = new Xlsx($spreadsheet);

ob_end_clean(); // Bersihkan output buffer

// Atur header untuk pengunduhan file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
?>