<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\Relation;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'subject_class_id',
        'classroom_id',
        'time_slot_id',
        'substitute_employee_id',
    ];
    public function subjectClasses(): BelongsTo{
        return $this->belongsto(SubjectClass::class);
    }
    public static function getSchedules()
    {
        return self::select('id')
        ->get();
    }
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class,'time_slot_id');
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class,'classroom_id');
    }

    public function subjectClass(): BelongsTo
    {
        return $this->belongsto(SubjectClass::class, 'subject_class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->subjectClass->belongsto(Subject::class, 'subject_id');
    }

    public static function getAllSchedules()
    {
        return self::with(['timeSlot', 'classroom', 'subjectClass.subject'])
            ->orderBy('id', 'desc')
            ->get();
    }


    public static function getSchedulesForCreate()
    {
        return [
            'classrooms' => Classroom::all(),
            'time_slots' => TimeSlot::all(),
            'subject_classes' => SubjectClass::all()
        ];
    }

    public static function getSchedulesForEdit()
    {
        return [
            'classrooms' => Classroom::all(),
            'time_slots' => TimeSlot::paginate(),
            'subject_classes' => SubjectClass::all()
        ];
        
    }

    public static function validate($data, $rules, $messages)
    {
        return Validator::make($data, $rules, $messages);
    }

    public static function findScheduleById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateSchedule($id, $data)
    {
        $schedule = self::findOrFail($id);
        $schedule->update($data);
        return $schedule;
    }

    public static function deleteSchedule($id)
    {
        $schedule = self::findOrFail($id);
        $schedule->delete();
    }

    public static function getNameSchedules()
    {
        return self::get(['id']);
    }

    public static function getNameScheduleById($id)
    {
        return self::where('id', $id)
            ->select('id')
            ->firstOrFail();
    }

    public function semester()
    {
        return $this->subjectClass->semester();
    }

    public static function createSchedule($data, $scheduleType)
    {
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dayOfWeek = $currentDate->dayOfWeek;
            $shouldCreateSchedule = ($scheduleType === 'odd')
                ? in_array($dayOfWeek, [1, 3, 5])
                : in_array($dayOfWeek, [2, 4, 6]);

            if ($shouldCreateSchedule) {
                self::create([
                    'time_slot_id' => $data['time_slot_id'],
                    'classroom_id' => $data['classroom_id'],
                    'date' => $currentDate->toDateString(),
                    'subject_class_id' => $data['subject_class_id'],
                    'schedule_day' => $currentDate->toDateString(),
                ]);
            }

            $currentDate->addDay();
        }
    }

    public static function getPaginatedSchedules($perPage = 10)
    {
        return self::orderBy('id', 'desc')->paginate($perPage);
    }

}
