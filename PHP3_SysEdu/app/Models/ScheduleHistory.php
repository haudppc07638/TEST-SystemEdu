<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleHistory extends Model
{
    use HasFactory;

    protected $table = 'schedule_histories';

    protected $fillable = [
        'schedule_id',
        'date',
        'subject_class_id',
        'classroom_id',
        'time_slot_id',
        'substitute_employee_id',
    ];

    /**
     * Liên kết đến model Schedule.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Liên kết đến model SubjectClass.
     */
    public function subjectClass(): BelongsTo
    {
        return $this->belongsTo(SubjectClass::class);
    }

    /**
     * Liên kết đến model Classroom.
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Liên kết đến model TimeSlot.
     */
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    /**
     * Liên kết đến model Employee (nhân viên thay thế).
     */
    public function substituteEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'substitute_employee_id');
    }
}
