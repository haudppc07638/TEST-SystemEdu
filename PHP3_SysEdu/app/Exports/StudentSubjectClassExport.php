<?php
namespace App\Exports;

use App\Models\StudentSubjectClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class StudentSubjectClassExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $subjectClassName;
    protected $headerStyle;
    protected $subjectClassId;
    protected $titleStyle;

    public function __construct($subjectClassName, $subjectClassId)
    {
        $this->subjectClassName = $subjectClassName;
        $this->subjectClassId = $subjectClassId;

        // Define header style
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

        // Define title style
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
                    'color' => ['argb' => '4792e8'],
                ],
            ],
        ];
    }

    public function collection()
    {
        return StudentSubjectClass::with('student', 'subjectClass')
            ->where('subject_class_id', $this->subjectClassId)
            ->select('student_id', 'midterm_score', 'final_score', 'total_score')
            ->get()
            ->map(function ($studentSubjectClass,$index) {
                return [
                    'stt' => $index + 1,
                    'fullname' => $studentSubjectClass->student->fullname,
                    'code' => $studentSubjectClass->student->code,
                    'email' => $studentSubjectClass->student->email,
                    'midterm_score' => $studentSubjectClass->midterm_score,
                    'final_score' => $studentSubjectClass->final_score,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'STT',  
            'Họ và tên',
            'Mã sinh viên',
            'Email',
            'Điểm Giữa Kỳ',
            'Điểm Cuối Kỳ',
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

                // tên sheet
                $sheet->setTitle('BangDiemSinhVien');   

                // tiêu đề
                $event->sheet->setCellValue('A1', 'SYSEDU - Bảng Điểm Sinh Viên Lớp ' . $this->subjectClassName);
                $event->sheet->mergeCells('A1:F1'); // Gộp ô
                $event->sheet->getStyle('A1:F1')->applyFromArray($this->titleStyle); // Áp dụng style cho tiêu đề

                // Apply header style
                $sheet->getStyle('A2:F2')->applyFromArray($this->headerStyle);

                // Set row height
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(6); // STT
                $sheet->getColumnDimension('B')->setWidth(20); // Họ và tên
                $sheet->getColumnDimension('C')->setWidth(15); // Mã sinh viên
                $sheet->getColumnDimension('D')->setWidth(30); // Email
                $sheet->getColumnDimension('E')->setWidth(15); // Điểm Giữa Kỳ
                $sheet->getColumnDimension('F')->setWidth(15); // Điểm Cuối Kỳ

                // Apply validation for Điểm Giữa Kỳ and Điểm Cuối Kỳ
                $highestRow = $sheet->getHighestRow();

                // Điểm Giữa Kỳ validation
                $validationD = $sheet->getCell('E3')->getDataValidation();
                $validationD->setType(DataValidation::TYPE_DECIMAL)
                    ->setOperator(DataValidation::OPERATOR_BETWEEN)
                    ->setFormula1('1')
                    ->setFormula2('10')
                    ->setShowErrorMessage(true)
                    ->setErrorTitle('Dữ liệu không hợp lệ')
                    ->setError('Điểm được quy định từ 1 đến 10 và khoảng cách là 0.25')
                    ->setPromptTitle('Dữ liệu không hợp lệ')
                    ->setPrompt('Điểm được quy định từ 1 đến 10 và khoảng cách là 0.25');

                // Apply validation to entire column D
                for ($row = 3; $row <= $highestRow; $row++) {
                    $cell = 'E' . $row;
                    $sheet->getCell($cell)->setDataValidation($validationD);
                }

                // Điểm Cuối Kỳ validation
                $validationE = $sheet->getCell('F3')->getDataValidation();
                $validationE->setType(DataValidation::TYPE_DECIMAL)
                    ->setOperator(DataValidation::OPERATOR_BETWEEN)
                    ->setFormula1('1')
                    ->setFormula2('10')
                    ->setShowErrorMessage(true)
                    ->setErrorTitle('Dữ liệu không hợp lệ')
                    ->setError('Điểm được quy định từ 1 đến 10 và khoảng cách là 0.25')
                    ->setPromptTitle('Dữ liệu không hợp lệ')
                    ->setPrompt('Điểm được quy định từ 1 đến 10 và khoảng cách là 0.25');

                // Apply validation to entire column E
                for ($row = 3; $row <= $highestRow; $row++) {
                    $cell = 'F' . $row;
                    $sheet->getCell($cell)->setDataValidation($validationE);
                }
            }
        ];
    }
}
