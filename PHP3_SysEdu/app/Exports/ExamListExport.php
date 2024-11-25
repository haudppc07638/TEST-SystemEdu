<?php

// namespace App\Exports;

// use App\Models\StudentSubjectClass;
// use App\Models\SubjectClass;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Concerns\WithCustomStartCell;
// use Maatwebsite\Excel\Events\AfterSheet;

// class ExamListExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
// {
//     protected $subjectClassId;

//     public function collection()
//     {
//         $subjectClass = SubjectClass::findOrFail($this->subjectClassId);

//         dd($subjectClass);

//         $students = StudentSubjectClass::with(['student', 'scores.subjectScoreType'])
//             ->where('subject_class_id', $this->subjectClassId)
//             ->get();

//         $qualifiedStudents = [];
//         $unqualifiedStudents = [];

//         foreach ($students as $studentSubjectClass) {
//             $totalScore = $studentSubjectClass->scores
//                 ->where('subject_score_type_id', 'multi')
//                 ->sum('score');

//             $totalSessions = $studentSubjectClass->attendances->count();
//             $absentCount = $studentSubjectClass->attendances->where('status', 0)->count();
//             $absenceRate = $totalSessions > 0 ? ($absentCount / $totalSessions) * 100 : 0;

//             if ($totalScore > 5 && $absenceRate > 20) {
//                 $qualifiedStudents[] = [
//                     'Mã SV' => $studentSubjectClass->student->code,
//                     'Họ và tên' => $studentSubjectClass->student->full_name,
//                     'Tổng điểm' => $totalScore,
//                     'Tỷ lệ vắng (%)' => round($absenceRate, 2),
//                 ];
//             } else {
//                 $unqualifiedStudents[] = [
//                     'Mã SV' => $studentSubjectClass->student->code,
//                     'Họ và tên' => $studentSubjectClass->student->full_name,
//                     'Tổng điểm' => $totalScore,
//                     'Tỷ lệ vắng (%)' => round($absenceRate, 2),
//                     'Ghi chú' => 'Không đủ điều kiện', // Hoặc thêm lý do cụ thể
//                 ];
//             }
//         }

//         return [
//             'qualified' => collect($qualifiedStudents), 
//             'unqualified' => collect($unqualifiedStudents), 
//         ];
//     }

//     public function headings(): array
//     {
//         return [
//             'Mã SV',
//             'Họ và tên',
//             'Tổng điểm',
//             'Tỷ lệ vắng (%)',
//         ];
//     }

//     public function startCell(): string
//     {
//         return 'A2';
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 $sheet = $event->sheet->getDelegate();
//                 $sheet->setTitle('DSSV đủ điều kiện');

//                 // Xuất danh sách đủ điều kiện
//                 $qualifiedData = $this->collection()['qualified'];
//                 $this->writeDataToSheet($sheet, $qualifiedData);

//                 // Tạo sheet mới cho danh sách không đủ điều kiện
//                 $sheet->getParent()->createSheet();
//                 $sheet->getParent()->setActiveSheetIndex(1);
//                 $sheet = $event->sheet->getDelegate();
//                 $sheet->setTitle('DSSV không đủ điều kiện');

//                 // Xuất danh sách không đủ điều kiện
//                 $unqualifiedData = $this->collection()['unqualified'];
//                 $this->writeDataToSheet($sheet, $unqualifiedData, true);
//             }
//         ];
//     }

//     private function writeDataToSheet($sheet, $data, $isUnqualified = false)
//     {

//         $sheet->fromArray($this->headings(), null, 'A1');


//         $sheet->fromArray($data->toArray(), null, 'A2');

//         if ($isUnqualified) {
//             $sheet->getCell('E1')->setValue('Ghi chú');
//         }

//         foreach (range('A', 'E') as $column) {
//             $sheet->getColumnDimension($column)->setAutoSize(true);
//         }
//     }
// }
