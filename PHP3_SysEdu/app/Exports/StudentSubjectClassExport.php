<?php

namespace App\Exports;

use App\Models\StudentSubjectClass;
use App\Models\SubjectScoreType;
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
        // Lấy danh sách loại điểm cho môn học
        $scoreTypes = SubjectScoreType::where('subject_id', $this->subjectClassId)
            ->with('scoreType')
            ->get();

        // Lấy danh sách sinh viên cùng với điểm
        return StudentSubjectClass::with(['student', 'scores.subjectScoreType'])
            ->where('subject_class_id', $this->subjectClassId)
            ->get()
            ->map(function ($studentSubjectClass, $index) use ($scoreTypes) {
                $row = [
                    'stt' => $index + 1,
                    'full_name' => $studentSubjectClass->student->full_name,
                    'code' => $studentSubjectClass->student->code,
                    'email' => $studentSubjectClass->student->email,
                ];

                // Thêm các điểm theo loại điểm
                foreach ($scoreTypes as $scoreType) {
                    $score = $studentSubjectClass->scores
                        ->where('subject_score_type_id', $scoreType->id)
                        ->first();
                    $row[$scoreType->scoreType->name] = $score ? $score->score : '';
                }
                

                return $row;
            });
    }

    public function headings(): array
    {
        // Lấy danh sách loại điểm cho môn học
        $scoreTypes = SubjectScoreType::where('subject_id', $this->subjectClassId)->with('scoreType')->get();

        $headings = [
            'STT',
            'Họ và tên',
            'Mã sinh viên',
            'Email',
        ];

        // Thêm tên các loại điểm vào tiêu đề
        foreach ($scoreTypes as $scoreType) {
            $headings[] = $scoreType->scoreType->name;
        }

        return $headings;
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
                $sheet->getStyle('A2:' . $sheet->getHighestColumn() . '2')->applyFromArray($this->headerStyle);

                // Set row height
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(6); // STT
                $sheet->getColumnDimension('B')->setWidth(20); // Họ và tên
                $sheet->getColumnDimension('C')->setWidth(15); // Mã sinh viên
                $sheet->getColumnDimension('D')->setWidth(30); // Email

                // Lấy danh sách các loại điểm cho môn học
                $scoreTypes = SubjectScoreType::where('subject_id', $this->subjectClassId)->with('scoreType')->get();
                $startColumn = 'E'; // Bắt đầu từ cột E

                // Đặt độ rộng cho các cột điểm
                foreach ($scoreTypes as $index => $scoreType) {
                    $sheet->getColumnDimension(chr(ord($startColumn) + $index))->setWidth(15); // Điểm loại
                }

                // Apply validation cho các cột điểm
                $highestRow = $sheet->getHighestRow();
                foreach ($scoreTypes as $index => $scoreType) {
                    $columnLetter = chr(ord($startColumn) + $index); // Tính cột dựa trên E, F, G, ...

                    // Validation cho từng loại điểm
                    $validation = $sheet->getCell($columnLetter . '3')->getDataValidation();
                    $validation->setType(DataValidation::TYPE_DECIMAL)
                        ->setOperator(DataValidation::OPERATOR_BETWEEN)
                        ->setFormula1('1')
                        ->setFormula2('10')
                        ->setShowErrorMessage(true)
                        ->setErrorTitle('Dữ liệu không hợp lệ')
                        ->setError('Điểm được quy định từ 1 đến 10 và khoảng cách là 0.25')
                        ->setPromptTitle('Dữ liệu không hợp lệ')
                        ->setPrompt('Điểm được quy định từ 1 đến 10 và khoảng cách là 0.25');

                    // Áp dụng xác thực cho toàn bộ cột
                    for ($row = 3; $row <= $highestRow; $row++) {
                        $cell = $columnLetter . $row;
                        $sheet->getCell($cell)->setDataValidation($validation);
                    }
                }

                // Thêm border cho toàn bộ bảng
                $borderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'], // Màu của border
                        ],
                    ],
                ];

                // Xác định phạm vi cần thêm border
                $lastColumn = $sheet->getHighestColumn(); // Cột cuối cùng
                $sheet->getStyle('A1:' . $lastColumn . $highestRow)->applyFromArray($borderStyle); // Áp dụng border cho toàn bộ bảng
            }
        ];
    }
}
