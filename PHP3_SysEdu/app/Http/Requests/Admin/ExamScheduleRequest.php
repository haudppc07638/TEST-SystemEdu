<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExamScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $scheduleId = $this->input('schedule_id');
        $examDate = DB::table('schedules')->where('id', $scheduleId)->value('date');
        $timeSlotId = DB::table('schedules')->where('id', $scheduleId)->value('time_slot_id');

        return [
            'schedule_id' => 'required|exists:schedules,id',
            'teacher_1' => [
                'required',
                'exists:employees,id',
                function ($attribute, $value, $fail) use ($examDate, $timeSlotId) {
                    if ($value == $this->input('teacher_2')) {
                        $fail('Giám thị 1 và giám thị 2 không được trùng nhau.');
                    }

                    $this->checkTeacherScheduleConflict($value, $examDate, $timeSlotId, $fail);
                },
            ],
            'teacher_2' => [
                'nullable',
                'exists:employees,id',
                function ($attribute, $value, $fail) use ($examDate, $timeSlotId) {
                    if ($value == $this->input('teacher_1')) {
                        $fail('Giám thị 2 và giám thị 1 không được trùng nhau.');
                    }

                    $this->checkTeacherScheduleConflict($value, $examDate, $timeSlotId, $fail);
                },
            ],
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ];
    }

    public function messages()
    {
        return [
            'schedule_id.required' => 'Chọn lịch học để tạo lịch thi.',
            'schedule_id.exists' => 'Lịch học không tồn tại.',
            'teacher_1.required' => 'Cần chọn giám thị 1.',
            'teacher_1.exists' => 'Giám thị 1 không tồn tại.',
            'teacher_2.exists' => 'Giám thị 2 không tồn tại.',
            'student_ids.required' => 'Danh sách sinh viên không được để trống.',
            'student_ids.*.exists' => 'Sinh viên không tồn tại.',
        ];
    }

    protected function checkTeacherScheduleConflict($teacherId, $examDate, $timeSlotId, $fail)
    {
        $isTeachingClass = DB::table('schedules')
            ->join('subject_classes', 'schedules.subject_class_id', '=', 'subject_classes.id')
            ->where('schedules.id', $this->input('schedule_id'))
            ->where('subject_classes.employee_id', $teacherId)
            ->exists();
    
        if ($isTeachingClass) {
            return;
        }
        $conflictExists = DB::table('schedules')
            ->join('subject_classes', 'schedules.subject_class_id', '=', 'subject_classes.id')
            ->where(function ($query) use ($teacherId) {
                $query->where('subject_classes.employee_id', $teacherId)
                    ->orWhere('schedules.substitute_employee_id', $teacherId);
            })
            ->whereDate('schedules.date', $examDate)
            ->where('schedules.time_slot_id', $timeSlotId)
            ->exists();
        if ($conflictExists) {
            $fail('Giảng viên ID ' . $teacherId . ' đã có lịch vào ngày ' . $examDate . ' tại khung giờ này.');
        }
    }
    
}
