<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class EligibleStudentsExport implements FromArray, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $students;
    protected $subjectClassName;
    protected $headerStyle;
    protected $titleStyle;

    public function __construct(array $students, $subjectClassName)
    {
        $this->students = $students;
        $this->subjectClassName = $subjectClassName;

        $this->headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => '4c4f51'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'd6dce3',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '4792e8'],
                ],
            ],
        ];

        $this->titleStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => '3e4042'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '808080'],
                ],
            ],
        ];
    }

    // Dữ liệu xuất ra file Excel
    public function array(): array
    {
        return $this->students;
    }

    public function headings(): array
    {
        return [
            'STT',
            'Mã sinh viên',
            'Họ và tên',
            'Điểm',
            'Ký tên',
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Cắt ngắn tên sheet nếu nó dài hơn 31 ký tự
                $sheetTitle = 'Danh Sách Sinh Viên Đủ Điều Kiện Thi - ' . $this->subjectClassName;
                if (strlen($sheetTitle) > 31) {
                    $sheetTitle = substr($sheetTitle, 0, 31);
                }
    
                // Tên sheet
                $sheet->setTitle('DSSV đủ điều kiện thi');
    
                // Tính cột cuối cùng
                $totalColumns = 5;
                $lastColumn = Coordinate::stringFromColumnIndex($totalColumns);
    
                // Tiêu đề
                $event->sheet->setCellValue('A1', 'SYSEDU - Danh Sách Sinh Viên Đủ Điều Kiện Thi - ' . $this->subjectClassName);
                $event->sheet->mergeCells("A1:{$lastColumn}1");
                $event->sheet->getStyle("A1:{$lastColumn}1")->applyFromArray($this->titleStyle);
    
                // Áp dụng style cho header
                $sheet->getStyle('A2:' . $sheet->getHighestColumn() . '2')->applyFromArray($this->headerStyle);
    
                // Set row height
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);
    
                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(6); // STT
                $sheet->getColumnDimension('B')->setWidth(15); // Mã sinh viên
                $sheet->getColumnDimension('C')->setWidth(30); // Họ và tên
                $sheet->getColumnDimension('D')->setWidth(10);
                $sheet->getColumnDimension('E')->setWidth(20);

                $sheet->getStyle('A1:' . $lastColumn . ($sheet->getHighestRow()))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '808080'],
                        ],
                    ],
                ]);
            }
        ];
    }
    
}
