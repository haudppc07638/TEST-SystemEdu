<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StuClass extends Model
{
    use HasFactory;
    protected $table = 'major_classes';
    protected $fillable = [
        'id',
        'training_system',
        'name',
        'quantity', 
        'status',
        'major_id',
        'start_date',
        'end_date',
        'employee_id',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }
    public function subjectClass(){
        return $this->belongsTo(SubjectClass::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'major_class_id');
    }
    public static function getClassesWithMajorId($id)
    {
        return self::with(['major'])
            ->where('major_id', $id)
            ->select('id', 'training_system', 'name', 'quantity', 'status', 'major_id', 'start_date', 'employee_id')
            ->latest()
            ->get();
    }

    public static function createClass($data)
    {
        return self::create($data);
    }

    public static function getClassById($id)
    {
        $class = self::with('employee', 'major')->findOrFail($id);
        return $class;
    }
    public static function updateClassById($id, $data)
    {
        $class = self::findOrFail($id);
        $class->update($data);
        return $class;
    }

    public static function deleteClass($id)
    {
        return self::findOrFail($id)
            ->delete();
    }

    public static function getNameClasses()
    {
        return self::select('id', 'name')->get();
    }

    public static function getAllClasses()
    {
        return self::with('major', 'employee')
            ->get();
    }

    public static function getAllForPdf()
    {
        return self::select('id', 'training_system', 'name', 'quantity', 'major_id', 'employee_id')
            ->get();
    }

    public static function studentCount($id)
    {
        $count = Student::where('major_class_id', $id)->count();
        return $count;
    }

    public static function detailMajorClass($major_class_id)
    {
        return self::with('major', 'employee')
            ->findOrFail($major_class_id);
    }
}
