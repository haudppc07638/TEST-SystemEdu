<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'teacher_1',
        'teacher_2',
        'schedule_id',
    ];

    public function schedule()      
    {
        return $this->belongsTo(Schedule::class);
    }

    public function students()
    {
        return $this->hasMany(ExamStudent::class);
    }

    public function teacher1()
    {
        return $this->belongsTo(Employee::class, 'teacher_1');
    }

    public function teacher2()
    {
        return $this->belongsTo(Employee::class, 'teacher_2');
    }
}