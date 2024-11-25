<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        return $this->hasMany(SubjectClass::class, 'subject_id');
    }

    public function subjectLecturers()
    {
        return $this->hasMany(SubjectLecturer::class);
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Subject::class, 'prerequisite_subjects', 'subject_id', 'prerequisite_id');
    }

    public function scoreTypes()
    {
        return $this->belongsToMany(ScoreType::class, 'subject_score_types', 'subject_id', 'score_type_id')
            ->withPivot('weight');
    }

    public function subjectScoreTypes()
    {
        return $this->hasMany(SubjectScoreType::class, 'subject_id');
    }

    public function lecturers()
    {
        return $this->hasMany(SubjectLecturer::class);
    }

    public static function getAllSubjects()
    {
        return self::with('major')->latest()->get();
    }
    public function setCreditAttribute($value)
    {
        $this->attributes['credit'] = $value;
    }
    public function setPriceAttribute()
    {
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

    public static function findSubjectById($id)
    {
        return self::findOrFail($id);
    }

    public static function getAllSubject()
    {
        return self::all();
    }

    public function getQrerequisitesSubject($id)
    {
        return self::with('prerequisites')->findOrFail($id);
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

    public static function getAllSubjectOfStudent($major_id)
    {
        return self::where('major_id', $major_id)
            ->get();
    }

    public static function getAvailableSubjectsForStudent($majorId)
    {
        $today = now()->toDateString();
    
        return self::where(function ($query) use ($majorId) {
                    $query->where('major_id', $majorId)
                          ->orWhereNull('major_id');
                })
                ->whereHas('subjectClasses', function ($query) use ($today) {
                    $query->where('registration_deadline', '>=', $today);
                })
                ->get();
    }

    public function getSubjectByMajor($major_id)
    {
        return self::where('major_id', $major_id)->get();
    }

    public static function createSubject(array $data)
    {
        $subject = self::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'credit' => $data['credit'],
            'description' => $data['description'],
            'major_id' => $data['major_id'] ?? null,
        ]);

        if (isset($data['score_types'])) {
            foreach ($data['score_types'] as $scoreTypeId) {
                $scoreType = ScoreType::find($scoreTypeId);
                $weight = $data['weights'][$scoreTypeId] ?? 0;

                if ($scoreType->type === 'multi') {
                    $quantity = $data['sub_scores'][$scoreTypeId] ?? 1;
                    $subWeight = $weight / $quantity;

                    for ($i = 1; $i <= $quantity; $i++) {
                        $subject->scoreTypes()->attach($scoreTypeId, [
                            'weight' => $subWeight,
                            'name' => "{$scoreType->name}{$i}",
                        ]);
                    }
                } else {
                    // Trường hợp single
                    $subject->scoreTypes()->attach($scoreTypeId, [
                        'weight' => $weight,
                        'name' => $scoreType->name,
                    ]);
                }
            }
        }

        if (isset($data['prerequisites'])) {
            $subject->prerequisites()->sync($data['prerequisites']);
        }

        return $subject;
    }


    public function updateSubject(array $data)
    {
        // Cập nhật thông tin cơ bản
        $this->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'credit' => $data['credit'],
            'description' => $data['description'],
            'major_id' => $data['major_id'] ?? null,
        ]);

        // Cập nhật môn tiên quyết nếu có
        if (isset($data['prerequisites'])) {
            $this->prerequisites()->sync($data['prerequisites']);
        } else {
            $this->prerequisites()->detach();
        }
        return $this;
    }


    public static function detailSubject($id)
    {
        return self::with('scoreTypes', 'prerequisites')->findOrFail($id);
    }

    public function syncLecturers(array $newLecturers)
    {
        $existingLecturers = $this->lecturers()->pluck('employee_id')->toArray();

        $lecturersToDelete = array_diff($existingLecturers, $newLecturers);
        if (!empty($lecturersToDelete)) {
            $this->lecturers()->whereIn('employee_id', $lecturersToDelete)->delete();
        }

        foreach ($newLecturers as $employeeId) {
            if (!in_array($employeeId, $existingLecturers)) {
                $this->lecturers()->create(['employee_id' => $employeeId]);
            }
        }
    }

    public static function getBySubjectClass($subjectClassId)
    {
        $subject = Subject::with('scoreTypes')->find($subjectClassId);
        $scoreTypes = $subject->scoreTypes;
        return $scoreTypes;
    }
    protected static function boot()
    {
        parent::boot();

        static::created(function (StudentSubjectClass $studentSubjectClass) {
            $subjectHistory = new SubjectHistory();
            $type = $subjectHistory->determineTypeBasedOnStatus($studentSubjectClass);
            Log::info('SubjectHistory type determined:', ['type' => $type]);
            SubjectHistory::insert([
                'student_subject_class_id' => $studentSubjectClass->id,
                'type' => $type,
            ]);
        });
    }
}
