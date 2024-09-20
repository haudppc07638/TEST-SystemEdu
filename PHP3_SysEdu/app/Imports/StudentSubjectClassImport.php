<?php

namespace App\Imports;

use App\Models\StudentSubjectClass;
use App\Models\Student;
use App\Models\SubjectClass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentSubjectClassImport implements ToModel, WithHeadingRow, WithStartRow
{
    protected $subjectClass;
    protected $errors = [];

    public function __construct($subjectClassName)
    {
        // Tìm SubjectClass dựa trên tên lớp môn
        $this->subjectClass = SubjectClass::where('name', $subjectClassName)->first();
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
        // Kiểm tra và gán giá trị của cột 'Mã sinh viên'
        $studentCode = $row['ma_sinh_vien'] ?? null;

        if (!$studentCode) {
            $this->errors[] = 'Dữ liệu nào đó đã thiếu mã sinh viên, vui lòng kiểm tra lại file!';
            return null;
        }

        // Tìm sinh viên dựa trên mã sinh viên (code)
        $student = Student::where('code', $studentCode)->first();

        if (!$student) {
            $this->errors[] = 'Có mã sinh viên không tồn tại, vui lòng kiểm tra lại file!';
        }

        if ($student && $this->subjectClass) {
            // Tìm bản ghi đã có trong bảng StudentSubjectClass
            $studentSubjectClass = StudentSubjectClass::where('student_id', $student->id)
                ->where('subject_class_id', $this->subjectClass->id)
                ->first();

            // Cập nhật điểm nếu đã có bản ghi
            if ($studentSubjectClass) {
                $studentSubjectClass->midterm_score = $row['diem_giua_ky'];
                $studentSubjectClass->final_score = $row['diem_cuoi_ky'];
                $studentSubjectClass->save();
            } else {
                // Nếu chưa có, tạo mới bản ghi
                return new StudentSubjectClass([
                    'student_id' => $student->id,
                    'subject_class_id' => $this->subjectClass->id,
                    'midterm_score' => $row['diem_giua_ky'],
                    'final_score' => $row['diem_cuoi_ky'],
                ]);
            }
        }

        return null;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
