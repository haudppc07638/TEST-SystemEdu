<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectLecturer extends Model
{
    protected $table = "subject_lecturers";

    protected $fillable = ["subject_id", "employee_id"];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public static function getNameSubjectByEmployeeId($employeeId)
    {
        return self::where('employee_id', $employeeId)
            ->with('subject')
            ->get()
            ->pluck('subject.name')
            ->toArray();
    }
}
