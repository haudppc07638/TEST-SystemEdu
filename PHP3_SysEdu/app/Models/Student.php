<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneOrManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'students';

    protected $fillable = [
        'fullname', 
        'email', 
        'password', 
        'code', 
        'phone', 
        'image', 
        'major_id', 
        'class_id',
    ];
    public function isStudent()
    {
        return true;
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function stuClass(): BelongsTo
    {
        return $this->belongsTo(StuClass::class, 'class_id');
    }

    public function subjectClass(): BelongsTo
    {
        return $this->belongsTo(SubjectClass::class);
    }
    public function totalTuition(): HasMany{
        return $this->hasMany(TotalTuition::class);
    }
    public function studentSubjectClasses(): HasMany{
        return $this->hasMany(StudentSubjectClass::class, 'student_id');
    }
    public function tuition(): HasOneOrManyThrough{
        return $this->hasOneThrough(
            Tuition::class,
            StudentSubjectClass::class,
            'student_id',
            'student_subject_class_id',
            'id',
            'id',
        );
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    
    public static function getStudentsByMajors($id)
    {
    return self::whereIn('major_id', $id)
    ->get();
    }

    public static function getAllStudents()
    {
        return self::with(['major', 'stuClass'])->orderBy('id', 'desc')->get();
    }

    public static function getStudentsForCreate()
    {
        return [
            'majors' => Major::select('id', 'name')->get(),
            'classes' => StuClass::select('id', 'name')->get(),
        ];
    }

    public static function getStudentsForEdit()
    {
        return [
            'majors' => Major::select('id', 'name')->get(),
            'classes' => StuClass::select('id', 'name')->get(),
        ];
    }

    public static function validate($data, $request)
    {
        $rules = $request->rules();

        $messages = $request->messages();

        return Validator::make($data, $rules, $messages);
    }

    public static function createStudent($data)
    {
        return self::create($data);
    }

    public static function findStudentById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateStudent($id, $data)
    {
        $student = self::findOrFail($id);
        $student->update($data);
        return $student;
    }

    public static function deleteStudent($id)
    {
        $student = self::findOrFail($id);
        $student->delete();
    }

    public static function getNameStudents()
    {
        return self::get(['id', 'fullname']);
    }

    public static function getNameStudentById($id)
    {
        return self::where('id', $id)
            ->select('id', 'fullname')
            ->firstOrFail();
    }

    public static function getStudentsWithMajorId($id)
    {
        return self::where('major_id', $id)
            ->select('id', 'fullname')
            ->get();
    }
    public static function getProfileStudent(){
        return self::all();
    }
    public static function getAllForPdf(){
        return self::select('id', 'fullname', 'email', 'phone', 'image', 'code', 'major_id', 'class_id')
        ->get();
    }

    public static function getCredits(){
        return self::with('subject_class', 'student')
        ->where('student_id', 'credit', 'subject_class_id')
        ->get();
    }
    // public static function getTuiTionStudent(){
    //     return static::
    // }
}
