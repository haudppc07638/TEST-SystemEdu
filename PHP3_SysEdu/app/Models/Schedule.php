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
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;


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
    public function subjectClasses(): BelongsTo
    {
        return $this->belongsto(SubjectClass::class);
    }
    public static function getSchedules()
    {
        return self::select('id')
            ->get();
    }
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class, 'time_slot_id');
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function subjectClass(): BelongsTo
    {
        return $this->belongsTo(SubjectClass::class, 'subject_class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->subjectClass->belongsTo(Subject::class, 'subject_id');
    }

    public function histories()
    {
        return $this->hasMany(ScheduleHistory::class);
    }

    public function attendances()
    {
        return $this->hasManyThrough(
            Attendance::class,
            StudentSubjectClass::class,
            'subject_class_id',
            'student_subject_class_id',
            'subject_class_id',
            'id'
        );
    }
    public function substituteEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'substitute_employee_id');
    }

    public function isEdited()
    {
        return $this->histories()->exists();
    }

    public function examSchedule()
    {
        return $this->hasOne(ExamSchedule::class);
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

        public static function createSchedule($data)
        {
            $startDate = Carbon::parse($data['start_date']);
            $endDate = Carbon::parse($data['end_date']);
            $selectedDays = $data['days_of_week'] ?? [];
        
            if (empty($selectedDays) || !is_array($selectedDays)) {
                throw new InvalidArgumentException('Danh sách ngày trong tuần không hợp lệ.');
            }
        
            $currentDate = $startDate->copy();
        
            while ($currentDate->lte($endDate)) {
                $dayOfWeek = $currentDate->dayOfWeek;
        
                // Kiểm tra nếu ngày hiện tại có trong danh sách các ngày được chọn
                if (in_array($dayOfWeek, $selectedDays)) {
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

    public static function getSchedulesBySubjectClassId($subjectClassId, $perPage = 20)
    {
        return self::where('subject_class_id', $subjectClassId)
            ->whereDoesntHave('examSchedule')
            ->orderBy('date', 'asc')
            ->paginate($perPage);
    }

    protected static function booted()
    {
        static::updating(function ($schedule) {
            DB::table('schedule_histories')->insert([
                'schedule_id' => $schedule->id,
                'date' => $schedule->getOriginal('date'),
                'subject_class_id' => $schedule->getOriginal('subject_class_id'),
                'classroom_id' => $schedule->getOriginal('classroom_id'),
                'time_slot_id' => $schedule->getOriginal('time_slot_id'),
                'substitute_employee_id' => $schedule->getOriginal('substitute_employee_id'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    public function getAttendanceStatus($date)
    {
        return $this->attendances()
            ->where('date', $date)
            ->get()
            ->pluck('status', 'student_subject_class_id');
    }

    public static function getScheduleWithStudents($scheduleId, $date)
    {
        $schedule = self::with([
            'timeSlot',
            'subjectClass.studentSubjectClasses.student',
            'subjectClass.studentSubjectClasses.attendances' => function ($query) use ($date) {
                $query->where('date', $date);
            }
        ])->findOrFail($scheduleId);

        return $schedule;
    }
    public function scopeUpcomingSchedules($query, $subjectClassId = null, $date = null)
    {
        $query->where('date', '>=', Carbon::today()->toDateString());
        if ($subjectClassId) {
            $query->where('subject_class_id', $subjectClassId);
        }
        if ($date) {
            $query->whereDate('date', $date);
        }

        return $query->orderBy('date', 'asc');
    }

    public static function getSchedulesByTeacher($teacherId, $subjectClassId = null, $date = null)
    {
        $query = self::whereHas('subjectClass', function ($query) use ($teacherId) {
            $query->where('employee_id', $teacherId);
        });
        $today = Carbon::today();
        // Lọc theo lớp môn (chỉ lấy lịch từ ngày hiện tại trở đi)
        if ($subjectClassId) {
            $query->where('subject_class_id', $subjectClassId)
                ->where('date', '>=', $today)
                ->orderBy('date'); // Chỉ lấy ngày từ hiện tại trở đi
        }

        // Lọc theo ngày (nếu có)
        if ($date) {
            $query->whereDate('date', $date); // Lấy lịch theo ngày cụ thể, không ràng buộc ngày hiện tại
        }

        return $query->with([
            'subjectClass.subject',
            'subjectClass.employee',
            'classroom',
            'timeSlot',
        ])->paginate(20);
    }

    public static function countEditedSchedulesBySubjectClass($subjectClassId)
    {
        return self::where('subject_class_id', $subjectClassId)
            ->whereHas('histories')
            ->count();
    }


}
