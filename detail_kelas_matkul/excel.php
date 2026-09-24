<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file ="Detail-Data-Kelas-Matkul-" . date('Y-m-d');

$query_kelas = mysqli_query($con, "SELECT * FROM tbl_detail_kelas_matkul")or die(mysqli_error($con));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Detail Data Kelas Matkul');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'ID DETAIL');
$sheet->setCellValue('C1', 'ID');
$sheet->setCellValue('D1', 'NIM');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:D1')->applyFromArray($styleArray);
$sheet->getStyle('A1:D1')->getFont()->setBold(true);

foreach (array('B', 'C', 'D') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_kelas)){;
    $id_detail = $data['id_detail'];
    $id= $data['id'];
    $nim = $data['nim'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $id_detail);
    $sheet->setCellValue("C" . $rowNumber, $id);
    $sheet->setCellValue("D" . $rowNumber, $nim);
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