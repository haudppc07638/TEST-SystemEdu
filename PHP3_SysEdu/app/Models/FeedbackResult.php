<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackResult extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedback_results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'results',
        'expertise',
        'feedback_question_id',
        'student_subject_class_id',
        'employee_id',
    ];

    /**
     * Relationships
     */

    // Feedback Question relationship
    public function feedbackQuestion()
    {
        return $this->belongsTo(FeedbackQuestion::class);
    }

    // Student Subject Class relationship
    public function studentSubjectClass()
    {
        return $this->belongsTo(StudentSubjectClass::class);
    }

}
