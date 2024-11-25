<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudentSubjectClass extends Model
{
    use HasFactory;

    protected $fillable = ['total_score', 'classification', 'status', 'student_id', 'subject_class_id'];

    public function student(): BeLongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function subjectClass(): BeLongsTo
    {
        return $this->belongsTo(SubjectClass::class);
    }
    public function tuition(): HasOne
    {
        return $this->hasOne(Tuition::class, 'student_subject_class_id');
    }
    public function scores()
    {
        return $this->hasMany(Score::class, 'student_subject_class_id');
    }
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_subject_class_id');
    }
    public function subject(): HasManyThrough
    {
        return $this->hasManyThrough(
            Subject::class,
            SubjectClass::class,
            'subject_id',
            'subject_class_id',
            'id',
            'id',
        );
    }
    // public function setMidtermScoreAttribute($value)
    // {
    //     $this->attributes['midterm_score'] = $value;
    //     $this->calculateTotalScore();
    // }

    // public function setFinalScoreAttribute($value)
    // {
    //     $this->attributes['final_score'] = $value;
    //     $this->calculateTotalScore();
    // }
    public static function validate($data, $request)
    {
        $rules = $request->rules();

        $messages = $request->messages();

        return Validator::make($data, $rules, $messages);
    }
    public static function getStudentSubClass($id)
    {
        return self::with('student', 'subjectClass', 'scores')->where('subject_class_id', $id)->get();
    }
    protected static function editStudentSubClass($id)
    {
        return self::with('subjectClass')->findOrFail($id);
    }
    protected static function updateStudentSubClass($id, $data)
    {
        $studentSubClass = self::findOrFail($id);
        $studentSubClass->update($data);
        return $studentSubClass;
    }

    public static function cancelStudentSubjectClass($studentId, $subjectClassId)
    {
        $studentSubjectClass = self::where('student_id', $studentId)
            ->where('subject_class_id', $subjectClassId)
            ->first();
        if ($studentSubjectClass) {
            $subjectClass = $studentSubjectClass->subjectClass;

            if ($subjectClass && $subjectClass->subject) {

                return $studentSubjectClass->delete();
            }
        }
        return false;
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
    public static function booted(): void
    {
        static::deleting(function (StudentSubjectClass $studentSubjectClass) {
            $studentId = $studentSubjectClass->student_id;
            $subjectClass = $studentSubjectClass->subjectClass;
            $subject = $subjectClass->subject;

            if ($studentId && $subject) {
                $totalTuition = TotalTuition::where('student_id', $studentId)->first();

                if ($totalTuition) {
                    $totalTuition->total_amount -= $subject->price;
                    $totalTuition->total_credit -= $subject->credit;

                    if ($totalTuition->total_amount <= 0 && $totalTuition->total_credit <= 0) {
                        $totalTuition->delete();
                    } else {
                        $totalTuition->save();
                    }
                }
            }
        });

        static::saving(function ($model) {
            $model->calculateTotalScore(); // tổng điểm
        });
    }

    public function calculateTotalScore()
    {
        $scores = $this->scores;

        if ($scores->isEmpty()) {
            $this->attributes['total_score'] = null;
            return;
        }

        $totalWeightedScore = 0;
        $totalWeight = 0;

        // Tính tổng điểm nhân trọng số và tổng trọng số
        foreach ($scores as $score) {
            $weight = $score->subjectScoreType->weight;
            $totalWeightedScore += $score->score * $weight;
            $totalWeight += $weight;
        }

        // Kiểm tra tổng trọng số để tránh chia cho 0
        if ($totalWeight > 0) {
            $averageScore = $totalWeightedScore / $totalWeight;
            $this->attributes['total_score'] = round($averageScore, 2);
        } else {
            $this->attributes['total_score'] = null;
        }

        // Cập nhật phân loại và trạng thái
        $this->updateClassification();
        $this->updateStatus();
    }

    protected function updateClassification()
    {
        $this->attributes['classification'] = $this->getClassificationAttribute();
    }

    public function getClassificationAttribute()
    {
        $totalScore = $this->attributes['total_score'] ?? 0;

        return match (true) {
            $totalScore >= 9 => 'Xuất sắc',
            $totalScore >= 8 => 'Giỏi',
            $totalScore >= 7 => 'Khá',
            $totalScore >= 6 => 'Trung bình',
            default => 'Yếu',
        };
    }

    protected function updateStatus()
    {
        $this->attributes['status'] = $this->attributes['total_score'] >= 5 ? 'passed' : 'failed';
    }

    public function getAttendanceForDate($date)
    {
        return $this->attendances()
            ->where('date', $date)
            ->first();
    }

    public function markAttendance($date, $status)
    {
        return $this->attendances()->updateOrCreate(
            ['date' => $date],
            ['status' => $status]
        );
    }
}
