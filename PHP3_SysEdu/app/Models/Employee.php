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
        'fullname',
        'email',
        'password',
        'phone',
        'image',
        'position',
        'faculty_id',
        'department_id',
    ];

    public function isEmployee()
    {
        return true;
    }
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
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
    public function subjectClasses(): HasMany{
        return $this->hasMany(SubjectClass::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public static function getAvailableTeachers($faculty_id){
        return self::where('position', 'Giáo viên')
        ->where('faculty_id', $faculty_id)
        ->whereDoesntHave('classes', function ($query){
            $query->where('status', 0);
        })
        ->get();
    }

    public static function getAllEmployees(){
        return self::with('faculty', 'department')
        ->orderBy('id', 'desc')
        ->get();
    }
    public static function getEmployeeById($id){
        return self::findOrFail($id);
    }

    public static function getTeachersByFaculties($id){
        return self::where('position', 'Giáo viên')
        ->whereIn('faculty_id', $id)
        ->get();
    }   

    public static function getAllForPdf(){
        return self::select('id', 'fullname', 'email', 'phone', 'image', 'position', 'faculty_id', 'department_id')
        ->get();
    }
    public static function getNameEmployees(){
        return self::select('id', 'fullname')
        ->get();
    }
}

