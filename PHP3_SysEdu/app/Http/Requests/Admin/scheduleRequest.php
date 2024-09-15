<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $scheduleId = $this->route('id'); // Lấy ID của lịch học từ route

        return [
            'time_slot_id' => [
                'required',
                'exists:time_slots,id',
                function ($attribute, $value, $fail) use ($scheduleId) {
                    $classroomId = $this->input('classroom_id');
                    $scheduleDay = $this->input('schedule_day');
                    $subjectClassId = $this->input('subject_class_id');

                    // Kiểm tra xem đã có lịch học cho phòng học vào ngày và ca học này chưa, ngoại trừ lịch học hiện tại
                    $existingSchedule = DB::table('schedules')
                        ->where('classroom_id', $classroomId)
                        ->where('schedule_day', $scheduleDay)
                        ->where('time_slot_id', $value)
                        ->where(function ($query) use ($scheduleId) {
                            if ($scheduleId) {
                                $query->where('id', '<>', $scheduleId);
                            }
                        })
                        ->exists();

                    if ($existingSchedule) {
                        return $fail('Ca học này đã được đặt cho phòng học vào ngày này.');
                    }

                    // Lấy subject_class và employee_id từ bảng subject_classes
                    $subjectClass = DB::table('subject_classes')
                        ->where('id', $subjectClassId)
                        ->first();

                    if ($subjectClass) {
                        $employeeId = $subjectClass->employee_id;
                        // Kiểm tra xem đã có lịch học cho employee_id vào ngày và ca học này chưa, ngoại trừ lịch học hiện tại
                        $existingEmployeeSchedule = DB::table('schedules')
                            ->join('subject_classes', 'schedules.subject_class_id', '=', 'subject_classes.id')
                            ->where('subject_classes.employee_id', $employeeId)
                            ->where('schedules.schedule_day', $scheduleDay)
                            ->where('schedules.time_slot_id', $value)
                            ->where(function ($query) use ($scheduleId) {
                                if ($scheduleId) {
                                    $query->where('schedules.id', '<>', $scheduleId);
                                }
                            })
                            ->exists();

                        if ($existingEmployeeSchedule) {
                            return $fail('Giáo viên đã có lịch dạy vào ngày và ca học này.');
                        }
                    }
                },
            ],
            'classroom_id' => [
                'required',
                'exists:classrooms,id',
                function ($attribute, $value, $fail) use ($scheduleId) {
                    $scheduleDay = $this->input('schedule_day');
                    $timeSlotId = $this->input('time_slot_id');

                    // Kiểm tra xem đã có lịch học cho phòng học vào ngày và ca học này chưa, ngoại trừ lịch học hiện tại
                    $existingSchedule = DB::table('schedules')
                        ->where('classroom_id', $value)
                        ->where('schedule_day', $scheduleDay)
                        ->where('time_slot_id', $timeSlotId)
                        ->where(function ($query) use ($scheduleId) {
                            if ($scheduleId) {
                                $query->where('id', '<>', $scheduleId);
                            }
                        })
                        ->exists();

                    if ($existingSchedule) {
                        return $fail('Phòng học này đã có lịch vào ngày và ca học này.');
                    }
                },
            ],
            'subject_class_id' => [
                'required',
                'exists:subject_classes,id'
            ],
            'schedule_day' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $subjectClass = DB::table('subject_classes')
                        ->where('id', $this->input('subject_class_id'))
                        ->first();

                    if (!$subjectClass) {
                        return $fail('Lớp môn học không hợp lệ.');
                    }

                    $scheduleDay = Carbon::parse($value);
                    $startDate = Carbon::parse($subjectClass->start_date);
                    $endDate = Carbon::parse($subjectClass->end_date);

                    if ($scheduleDay->lt($startDate)) {
                        return $fail('Ngày học không được nhỏ hơn ngày bắt đầu của lớp môn học.');
                    }

                    if ($scheduleDay->gt($endDate)) {
                        return $fail('Ngày học không được lớn hơn ngày kết thúc của lớp môn học.');
                    }
                }
            ],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'time_slot_id.required' => 'Khung giờ không được để trống',
            'time_slot_id.exists' => 'Khung giờ không hợp lệ',

            'classroom_id.required' => 'Phòng học không được để trống',
            'classroom_id.exists' => 'Phòng học không hợp lệ',

            'subject_class_id.required' => 'Lớp môn học không được để trống',
            'subject_class_id.exists' => 'Lớp môn học không hợp lệ',

            'schedule_day.required' => 'Ngày học không được để trống',
            'schedule_day.date' => 'Ngày học không hợp lệ',
        ];
    }
}
