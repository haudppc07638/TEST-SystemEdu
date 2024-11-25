<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherFreeSlot extends Model
{
    use HasFactory;

    protected $table = 'teacher_free_slots';

    protected $fillable = [
        'employee_id',
        'time_slot_id',
        'start_day',
        'end_day',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public static function getTimeSlotIds($employeeId)
    {
        return self::where('employee_id', $employeeId)->pluck('time_slot_id')->toArray();
    }
    public static function deleteUnusedTimeSlots($employeeId, array $toDelete)
    {
        self::where('employee_id', $employeeId)
            ->whereIn('time_slot_id', $toDelete)
            ->delete();
    }
    public static function addFreeTimeSlots($employeeId, array $selectedTimeSlots, $startDay, $endDay)
    {
        foreach ($selectedTimeSlots as $timeSlotId) {
            $freeSlot = self::where('employee_id', $employeeId)
                            ->where('time_slot_id', $timeSlotId)
                            ->first();

            if ($freeSlot) {
                // Nếu bản ghi đã tồn tại, cập nhật ngày bắt đầu và kết thúc
                $freeSlot->update([
                    'start_day' => $startDay,
                    'end_day' => $endDay,
                ]);
            } else {
                // Nếu chưa có bản ghi, tạo mới
                self::create([
                    'employee_id' => $employeeId,
                    'time_slot_id' => $timeSlotId,
                    'start_day' => $startDay,
                    'end_day' => $endDay,
                ]);
            }
        }
    }

}
