<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'employees';

    protected $fillable = [
        'full_name',
        'email',
        'code',
        'phone',
        'image',
        'position',
        'gender',
        'major_id',
        'department_id',
        'nation',
        'educational_level',
        'provice_city',
        'district',
        'commune_level',
        'identity_card',
        'card_issuance_date',
        'card_location',
        'house_number',
        'date_of_birth',
        'year_graduation',
        'graduate',
    ];

    public function isEmployee()
    {
        return true;
    }
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(StuClass::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
    public function subjectClasses(): HasMany
    {
        return $this->hasMany(SubjectClass::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function subjects()
    {
        return $this->hasMany(SubjectLecturer::class);
    }
    public function subjectLecturers()
    {
        return $this->hasMany(SubjectLecturer::class);
    }

    public function timeSlots()
    {
        return $this->belongsToMany(TimeSlot::class, 'teacher_free_slots', 'employee_id', 'time_slot_id');
    }

    public function substituteScheduleHistories()
    {
        return $this->hasMany(ScheduleHistory::class, 'substitute_employee_id');
    }

    public static function getAvailableTeachers($major_id){
        return self::where('position', 'teacher')
            ->whereDoesntHave('classes', function ($query) {
                $query->where('status', 0);
            })
            ->get();
    }

    public static function getAllEmployees()
    {
        return self::with('major', 'department')
            ->orderBy('id', 'desc')
            ->get();
    }
    public static function filterEmployees($filters = [])
{
    return self::query()
        ->when($filters['major_id'] ?? null, function ($query, $majorId) {
            $query->where('major_id', $majorId);
        })
        ->when($filters['department_id'] ?? null, function ($query, $departmentId) {
            $query->where('department_id', $departmentId);
        })
        ->with(['major', 'department'])
        ->orderBy('id', 'desc');
}
    public static function getEmployeeById($id)
    {
        return self::with('major', 'department')->findOrFail($id);
    }


    public static function getTeachersByFaculties($facultyId)
    {
        return self::whereHas('major', function ($query) use ($facultyId) {
            $query->where('faculty_id', $facultyId);
        })
            ->where('position', 'teacher')
            ->get();
    }

    public static function getAllForPdf()
    {
        return self::select('id', 'fullname', 'email', 'phone', 'image', 'position', 'major_id', 'department_id')
            ->get();
    }
    public static function getNameEmployees()
    {
        return self::select('id', 'full_name')
            ->get();
    }
}
