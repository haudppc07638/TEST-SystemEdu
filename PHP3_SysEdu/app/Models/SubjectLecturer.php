<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectLecturer extends Model
{
    protected $table = "subject_lecturers";

    protected $fillable = ["subject_id", "employee_id"];

    public function employee()
{
    return $this->belongsTo(Employee::class);
}
}
