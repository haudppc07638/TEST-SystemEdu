<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use  Illuminate\Support\Facades\Log;
class TotalTuition extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_amount',
        'total_credit',
        'tuition_status',
        'student_id',
    ];

    public function student(): BelongsTo{
        return $this->belongsTo(Student::class , 'student_id');
    }  
    public static function getTotal(){
        return static::get();
    }       
    public static function insertTuitionSubject($id){
        $student = Student::with('studentSubjectClasses.subjectClass.subject')->findOrFail($id);
        $totalData = Tuition::getTotalTuitionAndCredits($id);      
        Log::info("Total Amount: {$totalData['total_amount']}, Total Credit: {$totalData['total_credit']}");
        static::updateOrCreate( [
                'id' => $id,
                'student_id'    =>  $student->id,
                'total_amount'  => $totalData['total_amount'],        
                'total_credit'  => $totalData['total_credit'],       
                'tuition_status' => 'unpaid',  
            ]);
        return true;
       
    }     
 
}




