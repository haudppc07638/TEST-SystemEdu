<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;

class StudentSubjectClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'midterm_score',
        'final_score',
        'total_score',
        'classification',
        'student_id',
        'subject_class_id',
        'status',
    ];
    public function student(): BeLongsTo
    {
        return $this->belongsTo(Student::class);
    }
    public function subjectClass(): BeLongsTo
    {
        return $this->belongsTo(SubjectClass::class);
    }
    public function setMidtermScoreAttribute($value)
    {
        $this->attributes['midterm_score'] = $value;
        $this->calculateTotalScore();
    }

    public function setFinalScoreAttribute($value)
    {
        $this->attributes['final_score'] = $value;
        $this->calculateTotalScore();
    }

    protected function calculateTotalScore()
    {
        $midtermScore = $this->attributes['midterm_score'] ?? 0;
        $finalScore = $this->attributes['final_score'] ?? 0;
        $this->attributes['total_score'] = ($midtermScore * 0.4) + ($finalScore * 0.6);
        $this->updateClassfication();
        $this->updateStatusBasedOnTotalScore();
        $this->save();
    }
    public function getClassficationAttribute()
    {
        $totalScore = $this->attributes['total_score'];

        if ($totalScore >= 9) {
            return 'Loại Xuất sắc';
        } elseif ($totalScore >= 8) {
            return 'Loại Giỏi';
        } elseif ($totalScore >= 7) {
            return 'Loại Khá';
        } elseif ($totalScore >= 6) {
            return 'Loại Trung bình';
        } else {
            return 'Loại Yếu';
        }
    }

    protected function updateStatusBasedOnTotalScore()
    {
        $totalScore = $this->attributes['total_score'];

        if ($totalScore >= 5) {
            $this->attributes['status'] = 'passed';
        } else {
            $this->attributes['status'] = 'failed';
        }
    }
    protected function updateClassfication()
    {
        $this->attributes['classification'] = $this->getClassficationAttribute();
    }
    public static function validate($data, $request)
    {
        $rules = $request->rules();

        $messages = $request->messages();

        return Validator::make($data, $rules, $messages);
    }
    protected static function getStudentSubClass($id)
    {
        return self::with('student', 'subjectClass')->where('subject_class_id', $id)->get();
    }
    protected static function editStudentSubClass($id)
    {
        return self::findOrFail($id);
    }
    protected static function updateStudentSubClass($id, $data)
    {
        $studentSubClass = self::findOrFail($id);
        $studentSubClass->update($data);
        return $studentSubClass;
    }

    public static function cancelStudentSubjectClass($studentId, $subjectClassId)
    {
        return self::where('student_id', $studentId)
            ->where('subject_class_id', $subjectClassId)
            ->delete();
    }

    public static function insertStudentSubjectClass($studentId, $subjectClassId)
    {
        return self::insert([
            'student_id' => $studentId,
            'subject_class_id' => $subjectClassId,
            'midterm_score' => 0,
            'final_score' => 0,
            'total_score' => 0,
            'classification' => 'Chưa phân loại'
        ]);
    }

    public static function getRegisteredClassForSubject($studentId, $subjectId)
    {
        return self::where('student_id', $studentId)
            ->whereHas('subjectClass', function ($query) use ($subjectId) {
                $query->where('subject_id', $subjectId);
            })
            ->first();
    }

    public static function getChartDataByMajorId($major_id)
    {
        $classifications = ['Loại Xuất sắc', 'Loại Giỏi', 'Loại Khá', 'Loại Trung bình', 'Loại Yếu'];

        // Truy vấn dữ liệu theo major_id
        $data = self::whereHas('student', function ($query) use ($major_id) {
            $query->where('major_id', $major_id);
        })->selectRaw('classification, COUNT(*) as count')
            ->groupBy('classification')
            ->get()
            ->pluck('count', 'classification')
            ->toArray();

        // Tạo dữ liệu cho biểu đồ
        $chartData = array_fill_keys($classifications, 0);
        foreach ($data as $classification => $count) {
            if (array_key_exists($classification, $chartData)) {
                $chartData[$classification] = $count;
            }
        }

        return $chartData;
    }
}
