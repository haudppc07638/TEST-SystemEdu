<?php

namespace App\Exports;

use App\Models\StudentSubjectClass;
use App\Models\SubjectClass;
use App\Models\SubjectScoreType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
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
        $subjectClass = SubjectClass::findOrFail($this->subjectClassId);
        $scoreTypes = SubjectScoreType::where('subject_id', $subjectClass->subject_id)
            ->with('scoreType')
            ->get();

        // Nhóm các loại điểm đa thành phần
        $groupedScoreTypes = [];
        foreach ($scoreTypes as $scoreType) {
            $scoreTypeId = $scoreType->scoreType->id;
            if (!isset($groupedScoreTypes[$scoreTypeId])) {
                $groupedScoreTypes[$scoreTypeId] = [
                    'name' => $scoreType->scoreType->name,
                    'type' => $scoreType->scoreType->type,
                    'details' => [$scoreType]
                ];
            } else {
                $groupedScoreTypes[$scoreTypeId]['details'][] = $scoreType;
            }
        }

        return StudentSubjectClass::with(['student', 'scores.subjectScoreType'])
            ->where('subject_class_id', $this->subjectClassId)
            ->get()
            ->map(function ($studentSubjectClass, $index) use ($groupedScoreTypes) {
                $row = [
                    'stt' => $index + 1,
                    'full_name' => $studentSubjectClass->student->full_name,
                    'code' => $studentSubjectClass->student->code,
                    'email' => $studentSubjectClass->student->email,
                ];

                foreach ($groupedScoreTypes as $type) {
                    if ($type['type'] === 'multi') {
                        foreach ($type['details'] as $index => $scoreType) {
                            $score = $studentSubjectClass->scores
                                ->where('subject_score_type_id', $scoreType->id)
                                ->first();
                            $row[$type['name'] . ($index + 1)] = $score ? $score->score : '';
                        }
                    } else {
                        $score = $studentSubjectClass->scores
                            ->where('subject_score_type_id', $type['details'][0]->id)
                            ->first();
                        $row[$type['name']] = $score ? $score->score : '';
                    }
                }
                // dd($row);    
                return $row;
            });
    }

    public function headings(): array
    {
        $subjectClass = SubjectClass::findOrFail($this->subjectClassId);
        $scoreTypes = SubjectScoreType::where('subject_id', $subjectClass->subject_id)
            ->with('scoreType')
            ->get();

        // Nhóm các loại điểm đa thành phần
        $groupedScoreTypes = [];
        foreach ($scoreTypes as $scoreType) {
            $scoreTypeId = $scoreType->scoreType->id;
            if (!isset($groupedScoreTypes[$scoreTypeId])) {
                $groupedScoreTypes[$scoreTypeId] = [
                    'name' => $scoreType->scoreType->name,
                    'type' => $scoreType->scoreType->type,
                    'details' => [$scoreType]
                ];
            } else {
                $groupedScoreTypes[$scoreTypeId]['details'][] = $scoreType;
            }
        }

        $headings = [
            'STT',
            'Họ và tên',
            'Mã sinh viên',
            'Email',
        ];

        foreach ($groupedScoreTypes as $type) {
            if ($type['type'] === 'multi') {
                for ($i = 0; $i < count($type['details']); $i++) {
                    $headings[] = $type['name'] . ($i + 1);
                }
            } else {
                $headings[] = $type['name'];
            }
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

                // Lấy danh sách các loại điểm cho môn học
                $subjectClass = SubjectClass::findOrFail($this->subjectClassId);
                $scoreTypes = SubjectScoreType::where('subject_id', $subjectClass->subject_id)
                    ->with('scoreType')->get();

                $totalColumns = 4 + $scoreTypes->count();
                $lastColumn = Coordinate::stringFromColumnIndex($totalColumns); // Tính cột cuối cùng    

                // tiêu đề
                $event->sheet->setCellValue('A1', 'SYSEDU - Bảng Điểm Sinh Viên Lớp ' . $this->subjectClassName);
                $event->sheet->mergeCells("A1:{$lastColumn}1");
                $event->sheet->getStyle("A1:{$lastColumn}1")->applyFromArray($this->titleStyle); // Áp dụng style cho tiêu đề

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
                $subjectClass = SubjectClass::findOrFail($this->subjectClassId);
                $scoreTypes = SubjectScoreType::where('subject_id', $subjectClass->subject_id)->with('scoreType')->get();
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
                        ->setFormula1('0')
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
