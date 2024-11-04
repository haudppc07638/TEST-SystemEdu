<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\StudentSubjectClass;
use App\Models\SubjectClass;
use App\Models\SubjectScoreType;
use App\Models\Score;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class StudentSubjectClassImport implements ToModel, WithHeadingRow, WithStartRow, WithChunkReading, WithBatchInserts
{
    protected $subjectClass;
    protected $errors = [];

    public function __construct(SubjectClass $subjectClass)
    {
        $this->subjectClass = $subjectClass;
        ini_set('max_execution_time', 300); // Tăng thời gian thực thi lên 5 phút
    }

    // Bỏ qua hàng đầu tiên (chứa tiêu đề)
    public function startRow(): int
    {
        return 3;
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 100; // Xử lý mỗi lần 100 bản ghi
    }

    public function chunkSize(): int
    {
        return 100; // Đọc mỗi lần 100 bản ghi
    }

    public function model(array $row)
    {
        // dd($row);   
        $studentCode = trim($row['ma_sinh_vien'] ?? '');

        if (empty($studentCode)) {
            $this->errors[] = 'Thiếu mã sinh viên ở một dòng, vui lòng kiểm tra lại file!';
            return null;
        }

        // Tìm sinh viên dựa vào mã
        $student = Student::where('code', $studentCode)->first();

        if (!$student) {
            $this->errors[] = "Mã sinh viên '{$studentCode}' không tồn tại!";
            return null;
        }

        try {
            return DB::transaction(function () use ($student, $row) {
                $studentSubjectClass = $this->getStudentSubjectClassId($student->id);

                $subjectScoreTypes = SubjectScoreType::with('scoreType')
                    ->where('subject_id', $this->subjectClass->subject_id)
                    ->get();

                foreach ($subjectScoreTypes as $subjectScoreType) {
                    $columnName = mb_strtolower(str_replace(' ', '', $subjectScoreType->name));

                    if ($subjectScoreType->scoreType->type === 'multi') {
                        // Tìm index của điểm trong nhóm multi
                        $index = $subjectScoreTypes
                            ->where('score_type_id', $subjectScoreType->score_type_id)
                            ->search(function ($item) use ($subjectScoreType) {
                                return $item->id === $subjectScoreType->id;
                            });

                        $scoreValue = isset($row[$columnName]) ? $row[$columnName] : null;
                        
                        // Kiểm tra và xử lý giá trị điểm
                        if ($scoreValue !== null && $scoreValue !== '' && !is_numeric($scoreValue)) {
                            throw new \Exception("Điểm không hợp lệ cho cột {$columnName}");
                        }

                        if ($scoreValue === '') {
                            $scoreValue = null;
                        }

                        Score::updateOrCreate(
                            [
                                'student_subject_class_id' => $studentSubjectClass,
                                'subject_score_type_id' => $subjectScoreType->id,
                            ],
                            [
                                'name' => $columnName,
                                'score' => $scoreValue !== null ? (float)$scoreValue : null,
                            ]
                        );
                    } else {
                        // Xử lý điểm không phải multi
                        $scoreValue = isset($row[$columnName]) ? $row[$columnName] : null;

                        if ($scoreValue !== null && $scoreValue !== '' && !is_numeric($scoreValue)) {
                            throw new \Exception("Điểm không hợp lệ cho cột {$columnName}");
                        }

                        if ($scoreValue === '') {
                            $scoreValue = null;
                        }

                        Score::updateOrCreate(
                            [
                                'student_subject_class_id' => $studentSubjectClass,
                                'subject_score_type_id' => $subjectScoreType->id,
                            ],
                            [
                                'name' => $columnName,
                                'score' => $scoreValue !== null ? (float)$scoreValue : null,
                            ]
                        );
                    }
                }
            });
        } catch (\Throwable $e) {
            $this->errors[] = "Lỗi khi xử lý mã sinh viên '{$studentCode}': " . $e->getMessage();
        }

        return null;
    }

    private function getStudentSubjectClassId($studentId)
    {
        // Tìm hoặc tạo bản ghi trong bảng student_subject_classes
        $studentSubjectClass = StudentSubjectClass::firstOrCreate([
            'student_id' => $studentId,
            'subject_class_id' => $this->subjectClass->id,
        ]);

        return $studentSubjectClass->id;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
