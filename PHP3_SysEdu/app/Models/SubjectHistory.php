<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class SubjectHistory extends Model
{
  protected $table = 'subject_histories';
  protected $fillable = [
    'student_subject_class_id',
    'type',
  ];
  public function studentSubjectClass(): BelongsTo
  {
    return $this->belongsTo(StudentSubjectClass::class, 'student_subject_class_id');
  }
  public static function getSubjectHistoryOfStudent($studentId)
  {
    return self::whereHas('studentSubjectClass', function ($query) use ($studentId) {
      $query->where('student_id', $studentId);
    })
      ->with('studentSubjectClass')
      ->get();
  }
  public static function determineTypeBasedOnStatus(StudentSubjectClass $currentClass)
  {
    $previousClasses = StudentSubjectClass::where('id', $currentClass->id)
      ->whereHas('subjectClass', function ($query) use ($currentClass) {
        $query->where('subject_id', $currentClass->subjectClass->subject_id);
      })
      ->where('id', '<', $currentClass->id)
      ->get();

    if ($previousClasses->isEmpty()) {
      return $currentClass->status === 'passed' ? 'Đậu' : 'Rớt';
    }

    $previousPassed = $previousClasses->where('status', 'passed')->isNotEmpty();
    return $previousPassed ? 'Cải thiện' : 'Học lại';
  }
  // protected static function boot()
  //   {
  //       parent::boot();

  //       static::created(function (StudentSubjectClass $studentSubjectClass) {
  //           $subjectHistory = new SubjectHistory();
  //           $type = $subjectHistory->determineTypeBasedOnStatus($studentSubjectClass);
  //           SubjectHistory::insert([
  //               'student_subject_class_id' => $studentSubjectClass->id,
  //               'type' => $type,
  //           ]);
  //       });
  //   }
}
