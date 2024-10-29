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
        // Các biến cần thiết
        $scheduleId = $this->route('id');
        $scheduleType = $this->input('schedule_type');
        $classroomId = $this->input('classroom_id');
        $subjectClassId = $this->input('subject_class_id');
        $timeSlotId = $this->input('time_slot_id');

        $requestStartDate = Carbon::parse($this->input('start_date'));
        $requestEndDate = Carbon::parse($this->input('end_date'));

        return [
            'schedule_type' => 'required|in:odd,even',
            'time_slot_id' => [
                'required',
                'exists:time_slots,id',
                function ($attribute, $value, $fail) use ($scheduleId, $scheduleType, $classroomId, $requestStartDate, $requestEndDate) {
                    $this->checkTeacherScheduleConflict($value, $classroomId, $scheduleId, $requestStartDate, $requestEndDate, $fail);
                    $this->checkScheduleConflict($value, $classroomId, $scheduleId, $scheduleType, $requestStartDate, $requestEndDate, $fail);
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
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ];
    }


    protected function checkScheduleConflict($timeSlotId, $classroomId, $scheduleId, $scheduleType, $startDate, $endDate, $fail)
    {
        $currentDate = $startDate->copy();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            // Chỉ kiểm tra những ngày chẵn/lẻ tương ứng với loại lịch
            if ($this->isScheduleTypeMismatch($currentDate, $scheduleType)) {
                // Bỏ qua các ngày không phù hợp
                $currentDate->addDay();
                continue;
            }

            // Kiểm tra xem đã có lịch nào ở phòng học này trong thời gian này chưa
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

            // Nếu đã có lịch thì trả về lỗi
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
            // Chỉ kiểm tra những ngày chẵn/lẻ tương ứng với loại lịch
            if ($this->isScheduleTypeMismatch($currentDate, $scheduleType)) {
                // Bỏ qua các ngày không phù hợp
                $currentDate->addDay();
                continue;
            }

            // Ghi log để theo dõi thông tin
            Log::info("Checking classroom conflict for date: {$currentDate->toDateString()} with classroom_id: $classroomId and time_slot_id: $timeSlotId");

            // Kiểm tra xem đã có lịch nào ở phòng học này trong thời gian này chưa
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

            // Nếu đã có lịch thì trả về lỗi
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
            // Kiểm tra ngày có phù hợp với loại lịch không
            if ($this->isScheduleTypeMismatch($currentDate, $scheduleType)) {
                $currentDate->addDay();
                continue;
            }

            // Kiểm tra trùng lịch dựa trên subject_class_id thay vì employee_id trong schedules
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
        $dayOfWeek = $date->dayOfWeek; // 0 = Chủ nhật, 1 = Thứ hai, ..., 6 = Thứ bảy

        if ($scheduleType === 'odd') {
            // Các ngày lẻ (odd): thứ Hai (1), thứ Tư (3), thứ Sáu (5)
            return !($dayOfWeek == 1 || $dayOfWeek == 3 || $dayOfWeek == 5);
        } elseif ($scheduleType === 'even') {
            // Các ngày chẵn (even): thứ Ba (2), thứ Năm (4), thứ Bảy (6)
            return !($dayOfWeek == 2 || $dayOfWeek == 4 || $dayOfWeek == 6);
        }

        return true; // Trả về true nếu không thuộc loại nào
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

            'schedule_type.required' => 'Bạn phải chọn loại lịch',
            'schedule_type.in' => 'Loại lịch không hợp lệ',
        ];
    }
}
