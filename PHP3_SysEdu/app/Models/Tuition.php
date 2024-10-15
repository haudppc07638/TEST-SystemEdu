<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Tuition extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $fillable = [
        'id',
        'student_subject_class_id',
    ];
    public function studentSubjectClasses(): BelongsTo{
        return $this->belongsTo(StudentSubjectClass::class,'student_subject_class_id');
    }
    public static function getSubjectStudentRegister(){
        return self::all();
    }
   public static function insertTuitionJoinClass($id){
    $studentSubjectClass = StudentSubjectClass::findOrFail($id);
    
    $tuition = self::create([
        'student_subject_class_id' => $id,
     ]);
     $subjectClass = $studentSubjectClass->subjectClass;
    if ($subjectClass) {
        $subject = $subjectClass->subject;
        if ($subject) {
            $totalTuition = TotalTuition::where('student_id', $studentSubjectClass->student_id)->first();

            if ($totalTuition) {
                // Add price and credit
                $totalTuition->total_amount += $subject->price;
                $totalTuition->total_credit += $subject->credit;
                $totalTuition->save(); // Save changes
            }
        }
    }

    return $totalTuition; 
    }
    public static function cancelTuitionJoinClass($studentSubjectClassId)
    {
        $studentSubjectClass = StudentSubjectClass::findOrFail($studentSubjectClassId);
        Tuition::where('student_subject_class_id', $studentSubjectClassId)->delete();

        return $studentSubjectClass->delete();
    }

    public static function getTotalTuitionAndCredits($studentId) {
        $tuitions = static::whereHas('studentSubjectClasses', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })
        ->with('studentSubjectClasses.subjectClass.subject')
        ->get();
    
        $totalAmount = 0;
        $totalCredit = 0;

        foreach ($tuitions as $tuition) {
            $subjectClass = $tuition->studentSubjectClasses->subjectClass;
            if ($subjectClass && $subjectClass->subject) {
                $totalAmount += $subjectClass->subject->price;
                $totalCredit += $subjectClass->subject->credit;
            }
        }
        
        return [
            'total_amount' => $totalAmount,
            'total_credit' => $totalCredit
        ];
    }
    
}
