<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $scheduleId = $this->route('id');
        $subjectClassId = $this->input('subject_class_id');
        $timeSlotId = $this->input('time_slot_id');
        $classroomId = $this->input('classroom_id');
        $date = Carbon::parse($this->input('date'));

        return [
            'date' => 'required|date',
            'time_slot_id' => [
                'required',
                'exists:time_slots,id',
                function ($attribute, $value, $fail) use ($scheduleId, $subjectClassId, $date) {

                    $this->checkTeacherScheduleConflict($value, $scheduleId, $subjectClassId, $date, $fail);
                    $this->checkStudentScheduleConflict($value, $scheduleId, $subjectClassId, $date, $fail);
                },
            ],
            'classroom_id' => [
                'required',
                'exists:classrooms,id',
                function ($attribute, $value, $fail) use ($scheduleId, $timeSlotId, $date) {
                    $this->checkClassroomConflict($value, $timeSlotId, $scheduleId, $date, $fail);
                },
            ],
            'subject_class_id' => 'required|exists:subject_classes,id',
        ];
    }

    protected function checkTeacherScheduleConflict($timeSlotId, $scheduleId, $subjectClassId, $date, $fail)
    {
        $existingSchedule = DB::table('schedules')
            ->where('time_slot_id', $timeSlotId)
            ->whereDate('date', $date->toDateString())
            ->where('subject_class_id', $subjectClassId)
            ->where(function ($query) use ($scheduleId) {
                if ($scheduleId) {
                    $query->where('id', '<>', $scheduleId);
                }
            })
            ->exists();

        if ($existingSchedule) {
            $fail('Giáo viên đã có lịch vào ngày ' . $date->toDateString() . ' trong khung giờ này.');
        }
    }

    protected function checkStudentScheduleConflict($timeSlotId, $scheduleId, $subjectClassId, $date, $fail)
    {
        $studentIds = DB::table('student_subject_classes')
            ->where('subject_class_id', $subjectClassId)
            ->pluck('student_id')
            ->toArray();

        $hasConflict = false;

        foreach ($studentIds as $studentId) {
            $existingSchedule = DB::table('schedules')
                ->where('time_slot_id', $timeSlotId)
                ->whereDate('date', $date->toDateString())
                ->where('subject_class_id', $subjectClassId)
                ->where(function ($query) use ($scheduleId) {
                    if ($scheduleId) {
                        $query->where('id', '<>', $scheduleId);
                    }
                })
                ->exists();

            if ($existingSchedule) {
                $studentName = DB::table('students')->where('id', $studentId)->value('code');
                $fail('Sinh viên ' . $studentName . ' đã có lịch vào ngày ' . $date->toDateString() . ' trong khung giờ này.');
                $hasConflict = true;
            }
        }

        if (!$hasConflict) {
            return null;
        }
    }

    protected function checkClassroomConflict($classroomId, $timeSlotId, $scheduleId, $date, $fail)
    {
        $existingSchedule = DB::table('schedules')
            ->where('classroom_id', $classroomId)
            ->where('time_slot_id', $timeSlotId)
            ->whereDate('date', $date->toDateString())
            ->where(function ($query) use ($scheduleId) {
                if ($scheduleId) {
                    $query->where('id', '<>', $scheduleId);
                }
            })
            ->exists();

        if ($existingSchedule) {
            return $fail('Phòng học này đã có lịch vào ngày ' . $date->toDateString() . ' trong khung giờ này.');
        }
    }

    public function messages()
    {
        return [
            'time_slot_id.required' => 'Khung giờ không được để trống',
            'time_slot_id.exists' => 'Khung giờ không hợp lệ',

            'classroom_id.required' => 'Phòng học không được để trống',
            'classroom_id.exists' => 'Phòng học không hợp lệ',

            'subject_class_id.required' => 'Lớp môn học không được để trống',
            'subject_class_id.exists' => 'Lớp môn học không hợp lệ',

            'date.required' => 'Ngày không được để trống',
            'date.date' => 'Ngày không hợp lệ',
        ];
    }
}
