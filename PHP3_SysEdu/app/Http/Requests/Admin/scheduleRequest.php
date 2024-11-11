<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $scheduleId = $this->route('id');
        $scheduleType = $this->input('schedule_type');
        $classroomId = $this->input('classroom_id');
        $subjectClassId = $this->input('subject_class_id');
        $timeSlotId = $this->input('time_slot_id');

        $requestStartDate = Carbon::parse($this->input('start_date'));
        $requestEndDate = Carbon::parse($this->input('end_date'));

        return [
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'schedule_type' => 'required|in:odd,even',
            'time_slot_id' => [
                'required',
                'exists:time_slots,id',
                function ($attribute, $value, $fail) use ($scheduleId, $scheduleType, $classroomId, $requestStartDate, $requestEndDate, $subjectClassId) {
                    $errors = [];
                    $this->checkStudentScheduleConflict($value, $scheduleId, $subjectClassId, $requestStartDate, $requestEndDate, function ($message) use (&$errors) {
                        $errors[] = $message;
                    });
                    $this->checkTeacherScheduleConflict($value, $classroomId, $scheduleId, $requestStartDate, $requestEndDate, function ($message) use (&$errors) {
                        $errors[] = $message;
                    });
                    $this->checkScheduleConflict($value, $classroomId, $scheduleId, $scheduleType, $requestStartDate, $requestEndDate, function ($message) use (&$errors) {
                        $errors[] = $message;
                    });
                    if (!empty($errors)) {
                        $fail(implode(' ⚠️ ', $errors));
                    }
                },
            ],
            'classroom_id' => [
                'required',
                'exists:classrooms,id',
                function ($attribute, $value, $fail) use ($scheduleId, $timeSlotId, $scheduleType, $requestStartDate, $requestEndDate) {
                    $this->checkClassroomConflict($value, $timeSlotId, $scheduleId, $scheduleType, $requestStartDate, $requestEndDate, $fail);
                },
            ],
            'subject_class_id' => [
                'required',
                'exists:subject_classes,id',
                function ($attribute, $value, $fail) use ($requestStartDate, $requestEndDate) {
                    $this->checkSubjectClassDates($value, $requestStartDate, $requestEndDate, $fail);
                },
            ],
        ];
    }

    protected function checkScheduleConflict($timeSlotId, $classroomId, $scheduleId, $scheduleType, $startDate, $endDate, $fail)
    {
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            if ($this->isScheduleTypeMismatch($currentDate, $scheduleType)) {
                $currentDate->addDay();
                continue;
            }

            $existingSchedule = DB::table('schedules')
                ->where('classroom_id', $classroomId)
                ->where('time_slot_id', $timeSlotId)
                ->whereDate('date', $currentDate->toDateString())
                ->where(function ($query) use ($scheduleId) {
                    if ($scheduleId) {
                        $query->where('id', '<>', $scheduleId);
                    }
                })
                ->exists();

            if ($existingSchedule) {
                return $fail('Ca học này đã được đặt cho phòng học vào ngày ' . $currentDate->toDateString() . ' vào khung giờ này.');
            }

            $currentDate->addDay();
        }
    }

    protected function checkClassroomConflict($classroomId, $timeSlotId, $scheduleId, $scheduleType, $startDate, $endDate, $fail)
    {
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            if ($this->isScheduleTypeMismatch($currentDate, $scheduleType)) {
                $currentDate->addDay();
                continue;
            }

            Log::info("Checking classroom conflict for date: {$currentDate->toDateString()} with classroom_id: $classroomId and time_slot_id: $timeSlotId");

            $existingSchedule = DB::table('schedules')
                ->where('classroom_id', $classroomId)
                ->where('time_slot_id', $timeSlotId)
                ->whereDate('date', $currentDate->toDateString())
                ->where(function ($query) use ($scheduleId) {
                    if ($scheduleId) {
                        $query->where('id', '<>', $scheduleId);
                    }
                })
                ->exists();

            if ($existingSchedule) {
                return $fail('Phòng học này đã có lịch vào ngày ' . $currentDate->toDateString() . ' vào khung giờ này.');
            }

            $currentDate->addDay();
        }
    }

    protected function checkTeacherScheduleConflict($timeSlotId, $classroomId, $scheduleId, $requestStartDate, $requestEndDate, $fail)
    {
        $subjectClassId = $this->input('subject_class_id');
        $subjectClass = DB::table('subject_classes')->where('id', $subjectClassId)->first();

        if (!$subjectClass) {
            return $fail('Lớp môn học không hợp lệ.');
        }

        $scheduleType = $this->input('schedule_type');

        $currentDate = $requestStartDate->copy();
        while ($currentDate->lessThanOrEqualTo($requestEndDate)) {
            if ($this->isScheduleTypeMismatch($currentDate, $scheduleType)) {
                $currentDate->addDay();
                continue;
            }

            $existingSchedule = DB::table('schedules')
                ->where('time_slot_id', $timeSlotId)
                ->whereDate('date', $currentDate->toDateString())
                ->where('subject_class_id', $subjectClassId)
                ->where(function ($query) use ($scheduleId) {
                    if ($scheduleId) {
                        $query->where('id', '<>', $scheduleId);
                    }
                })
                ->exists();

            if ($existingSchedule) {
                return $fail('Giáo viên đã có lịch vào ngày ' . $currentDate->toDateString() . ' trong khung giờ này.');
            }

            $currentDate->addDay();
        }
    }

    protected function checkSubjectClassDates($subjectClassId, $requestStartDate, $requestEndDate, $fail)
    {
        $subjectClass = DB::table('subject_classes')->where('id', $subjectClassId)->first();
        if (!$subjectClass) {
            return $fail('Lớp môn học không hợp lệ.');
        }

        $startDate = Carbon::parse($subjectClass->start_date);
        $endDate = Carbon::parse($subjectClass->end_date);

        if ($requestStartDate < $startDate || $requestEndDate > $endDate) {
            return $fail('Ngày bắt đầu và kết thúc phải nằm trong khoảng thời gian của lớp môn học.');
        }
    }

    protected function isScheduleTypeMismatch($date, $scheduleType)
    {
        $dayOfWeek = $date->dayOfWeek;

        if ($scheduleType === 'odd') {
            return !($dayOfWeek == 1 || $dayOfWeek == 3 || $dayOfWeek == 5);
        } elseif ($scheduleType === 'even') {
            return !($dayOfWeek == 2 || $dayOfWeek == 4 || $dayOfWeek == 6);
        }

        return true;
    }

    protected function checkStudentScheduleConflict($timeSlotId, $scheduleId, $subjectClassId, $requestStartDate, $requestEndDate, $fail)
    {
        $currentDate = $requestStartDate->copy();
        $studentIds = DB::table('student_subject_classes')
            ->where('subject_class_id', $subjectClassId)
            ->pluck('student_id')
            ->toArray();
 
        while ($currentDate->lessThanOrEqualTo($requestEndDate)) {
            if ($this->isScheduleTypeMismatch($currentDate, $this->input('schedule_type'))) {
                $currentDate->addDay();
                continue;
            }

            foreach ($studentIds as $studentId) {
                $subjectClassIds = DB::table('student_subject_classes')
                    ->where('student_id', $studentId)
                    ->pluck('subject_class_id');

                $existingSchedule = DB::table('schedules')
                    ->where('time_slot_id', $timeSlotId)
                    ->whereDate('date', $currentDate->toDateString())
                    ->whereIn('subject_class_id', $subjectClassIds)
                    ->where(function ($query) use ($scheduleId) {
                        if ($scheduleId) {
                            $query->where('id', '<>', $scheduleId);
                        }
                    })
                    ->exists();

                if ($existingSchedule) {
                    $studentName = DB::table('students')->where('id', $studentId)->value('code');

                    return $fail('Sinh viên ' . $studentName . ' đã có lịch vào ngày ' . $currentDate->toDateString() . ' trong khung giờ này.');
                }
            }

            $currentDate->addDay();
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

            'start_date.required' => 'Ngày bắt đầu không được để trống',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải sau hoặc bằng ngày hôm nay',

            'end_date.required' => 'Ngày kết thúc không được để trống',
            'end_date.date' => 'Ngày kết thúc không hợp lệ',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
        ];
    }
}
