<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'name',
        'credit',
        'price',
        'description',
        'major_id',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function subjectClasses(): HasMany
    {
        return $this->hasMany(SubjectClass::class);
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Subject::class, 'prerequisite_subjects', 'subject_id', 'prerequisite_id');
    }

    public static function getAllSubjects()
    {
        return self::with('major')->latest()->get();
    }
    public function setCreditAttribute($value){
        $this->attributes['credit'] = $value;
    }
    public function setPriceAttribute(){
        $credit = $this->attributes['credit'];
        $this->attributes['price'] = $credit * 250000; 
        $this->save();
    }

    public static function validate($data, $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();
        return Validator::make($data, $rules, $messages);
    }

    public static function createSubject($data)
    {
        return self::create($data);
    }

    public static function findSubjectById($id)
    {
        return self::findOrFail($id);
    }

    public static function getAllSubject()
    {
        return self::all();
    }

    public function getQrerequisitesSubject($id){
        return self::with('prerequisites')->findOrFail($id);
    }

    public static function updateSubject($id, $data)
    {
        $subject = self::findOrFail($id);
        $subject->update($data);
        return $subject;
    }

    public static function deleteSubject($id)
    {
        $subject = self::findOrFail($id);
        $name = $subject->name;
        $subject->delete();
        return $name;
    }
    public static function getCodeSubject()
    {
        return self::select('id', 'name')
        ->get();
    }

    public static function getAllSubjectOfStudent($major_id){
        return self::where('major_id', $major_id)
        ->get();
    }

    public static function getAvailableSubjectsForStudent($majorId)
    {
        $today = now()->toDateString();
        return self::where('major_id', $majorId)
            ->whereHas('subjectClasses', function ($query) use ($today) {
                // Kiểm tra thời gian đăng ký và bắt đầu lớp học
                $query->where('registration_deadline', '>=', $today);
            })
            ->get();
    }

    public function getSubjectByMajor($major_id){
        return self::where('major_id', $major_id)->get();
    }
}