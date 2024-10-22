<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $fillable = ['score', 'subject_score_type_id', 'student_subject_class_id'];

    public function subjectScoreType(): BelongsTo
    {
        return $this->belongsTo(SubjectScoreType::class);
    }

    public function studentSubjectClass(): BelongsTo
    {
        return $this->belongsTo(StudentSubjectClass::class);
    }
}
