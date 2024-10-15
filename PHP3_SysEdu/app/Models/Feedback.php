<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'student_id',
        'employee_id',
        'subject_class_id',
        'admin_feedback',
        'student_feedback',
        'rating',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subjectClass()
    {
        return $this->belongsTo(SubjectClass::class, 'subject_class_id');
    }

    public static function getAllFeedbacks()
    {
        return self::with('student')->orderBy('id', 'desc')->get();
    }

    public static function getStudentsForCreate()
    {
        return Student::select('id', 'name')->get();
    }

    public static function getStudentsForEdit()
    {
        return Student::select('id', 'name')->get();
    }

    public static function validate($data, $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        return Validator::make($data, $rules, $messages);
    }

    public static function createFeedback($data)
    {
        return self::create($data);
    }

    public static function findFeedbackById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateFeedback($id, $data)
    {
        $feedback = self::findOrFail($id);
        $feedback->update($data);
        return $feedback;
    }

    public static function deleteFeedback($id)
    {
        $feedback = self::findOrFail($id);
        $feedback->delete();
    }
}
