<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\StudentSubjectClass;
use App\Models\SubjectClass;
use App\Models\SubjectScoreType;
use App\Models\Score;
use App\Models\ScoreType;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentSubjectClassImport implements ToModel, WithHeadingRow, WithStartRow
{
    protected $subjectClass;
    protected $errors = [];

    public function __construct(SubjectClass $subjectClass)
    {
        $this->subjectClass = $subjectClass;
    }

    // Bỏ qua hàng đầu tiên (chứa tiêu đề file)
    public function startRow(): int
    {
        return 3;
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // Kiểm tra mã sinh viên
        $studentCode = $row['ma_sinh_vien'] ?? null;

        if (!$studentCode) {
            $this->errors[] = 'Thiếu mã sinh viên ở một dòng, vui lòng kiểm tra lại file!';
            return null;
        }

        // Tìm sinh viên dựa vào mã
        $student = Student::where('code', $studentCode)->first();

        if (!$student) {
            $this->errors[] = "Mã sinh viên '{$studentCode}' không tồn tại!";
            return null;
        }
        // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
        try {
            DB::transaction(function () use ($student, $row) {
                // Duyệt qua tất cả các loại điểm của lớp môn
                $subjectScoreTypes = SubjectScoreType::with('scoreType')->where('subject_id', $this->subjectClass->subject_id)->get();

                foreach ($subjectScoreTypes as $subjectScoreType) { // Lấy tên cột tương ứng với loại điểm từ file Excel

                    $columnName = strtolower(str_replace(' ', '_', $subjectScoreType->scoreType->name));    
                    // Kiểm tra nếu file có cột tương ứng

                    if (!isset($row[$columnName])) {
                        $this->errors[] = "Thiếu cột '{$columnName}' cho sinh viên '{$student->code}'.";
                        continue;
                    }

                    // Tạo hoặc cập nhật điểm
                    Score::updateOrCreate(
                        [
                            'student_subject_class_id' => $this->getStudentSubjectClassId($student->id),
                            'subject_score_type_id' => $subjectScoreType->id,
                        ],
                        [
                            'score' => $row[$columnName],
                        ]
                    );
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
