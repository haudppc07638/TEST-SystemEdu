<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'status',
        'student_subject_class_id'
    ];

    protected $casts = [
        'date' => 'date',
        'status' => 'boolean'
    ];

    public function studentSubjectClass()
    {
        return $this->belongsTo(StudentSubjectClass::class);
    }

    public static function markAttendanceForClass(array $studentSubjectClassIds, string $date, array $attendance)
    {
        foreach ($studentSubjectClassIds as $studentId) {
            Attendance::updateOrCreate(
                [
                    'student_subject_class_id' => $studentId,
                    'date' => $date,
                ],
                [
                    'status' => isset($attendance[$studentId]) ? $attendance[$studentId] : false,
                ]
            );
        }
    }
}
