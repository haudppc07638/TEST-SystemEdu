<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SubjectClass extends Model
{
    use HasFactory;
    protected $table = 'subject_classes';

    protected $fillable = [
        'id',
        'start_date',
        'quantity',
        'name',
        'end_date',
        'registration_deadline',
        'credit_id',
        'price',
        'employee_id',
        'subject_id',
        'semester_id',
        'major_class_id',
        'credit_price',
        'status'
    ];
    public function subject(): BelongsTo
    {
        return $this->belongsto(Subject::class, 'subject_id');
    }
    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }
    public function majorClass()
    {
        return $this->belongsTo(StuClass::class);
    }
    public function semester(): BelongsTo
    {
        return $this->belongsto(Semester::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'subject_class_id'); // Giả sử 'subject_class_id' là tên khóa ngoại trong bảng schedules
    }
    public function employee(): BelongsTo
    {
        return $this->belongsto(Employee::class);
    }
    public function studentSubjectClasses(): HasMany
    {
        return $this->hasMany(StudentSubjectClass::class, 'subject_class_id');
    }
    public function lecturer()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function lecturers()
    {
        return $this->hasMany(SubjectLecturer::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'subject_class_id');
    }

    public function scheduleHistories()
    {
        return $this->hasMany(ScheduleHistory::class);
    }

    public static function validate($data, $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        return Validator::make($data, $rules, $messages);
    }
    public static function createSubjectClass($data)
    {
        $data['price'] = 0;
        return self::create($data);
    }

    public static function findSubjectClassById($id)
    {
        return self::with('subject')->find($id);
    }

    public static function updateSubjectClass($id, $data)
    {
        $subjectClass = self::findOrFail($id);
        $subjectClass->update($data);
        return $subjectClass;
    }

    public static function deleteSubjectClass($id)
    {
        $subjectClass = self::findOrFail($id);
        $id = $subjectClass->id;
        $subjectClass->delete();
        return $id;
    }

    public function registeredStudentsCount()
    {
        return StudentSubjectClass::where('subject_class_id', $this->id)->count();
    }

    public function isFull()
    {
        return $this->registeredStudentsCount() >= $this->quantity;
    }

    public function studentsCountText()
    {
        $registeredCount = $this->registeredStudentsCount();
        return "{$registeredCount}/{$this->quantity}";
    }

    public static function getAvailableClassesForMajor($majorId, $currentDate, $subject_id)
    {
        return self::where('registration_deadline', '>=', $currentDate)
            ->where('subject_id', $subject_id)
            ->whereHas('subject', function ($query) use ($majorId) {
                $query->where('major_id', $majorId);
            })
            ->get();
    }
    public static function getAllSubjectClass()
    {
        return self::all();
    }

    public function getPriceAttribute()
    {
        $subjectCredits = $this->subject->credit;  
        $creditPrice = $this->attributes['credit_price'] ?? 0;
     
        Log::info("Số tín chỉ: $subjectCredits, Giá tín chỉ: $creditPrice");

        return $subjectCredits * $creditPrice;
    }
    protected static function boot()
    {
    parent::boot();

    static::saving(function (SubjectClass $subjectClass) {
        $subjectCredits = $subjectClass->subject->credit ?? 0;
        $creditPrice = $subjectClass->credit_price ?? 0;

        $subjectClass->price = $subjectCredits * $creditPrice;
    });
    }

    public function addStudents($majorClassId)
    {
        $students = Student::where('major_class_id', $majorClassId)->get();

        foreach ($students as $student) {
            StudentSubjectClass::create([
                'student_id' => $student->id,
                'subject_class_id' => $this->id,
                'total_score' => null,
                'classification' => null,
                'status' => 'fail',
            ]);
        }
    }

    public static function getAllDates()
    {
        return self::all()->mapWithKeys(function ($subjectClass) {
            return [
                $subjectClass->id => [
                    'start_date' => $subjectClass->start_date,
                    'end_date' => $subjectClass->end_date,
                ],
            ];
        });
    }

    public static function checkExistingClass($majorClassId, $subjectId)
    {
        return self::where('major_class_id', $majorClassId)
            ->where('subject_id', $subjectId)
            ->exists();
    }
}
