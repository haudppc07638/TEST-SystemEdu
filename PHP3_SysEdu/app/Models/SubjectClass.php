<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;

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
        'status'
    ];
    public function subject(): BelongsTo
    {
        return $this->belongsto(Subject::class, 'subject_id');
    }
    public function credit(): BelongsTo{
        return $this->belongsTo(Credit::class, 'credit_id');
    }
    public function stuClass(){
        return $this->hasMany(StuClass::class, 'major_class_id');
    }
    public function semester(): BelongsTo
    {
        return $this->belongsto(Semester::class);
    }
    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsto(Employee::class);
    }
    public function studentSubjectClasses(): HasMany
    {
        return $this->hasMany(StudentSubjectClass::class, 'subject_class_id');
    }
    
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'subject_class_id');
    }

    public static function validate($data, $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        return Validator::make($data, $rules, $messages);
    }
    public static function createSubjectClass($data)
    {
        return self::create($data);
    }

    public static function findSubjectClassById($id)
    {
        return self::findOrFail($id);
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
    public static function getAllSubjectClass(){
        return self::all();
    }
    public function getPriceAttribute()
    {
        $subjectCredits = $this->subject->credit;  
        $creditPrice = $this->credit->price;       

        return $subjectCredits * $creditPrice;     
    }
    
}
