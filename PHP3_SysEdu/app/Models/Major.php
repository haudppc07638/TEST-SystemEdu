<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors';

    protected $fillable = [
        'name',
        'faculty_id',
    ];

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(StuClass::class);
    }

    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }

    public static function getAllMajor()
    {
        return self::with('faculty')
        ->orderBy('id', 'desc')
        ->get();
    }

    public static function getFacultiesForCreate()
    {
        return Faculty::select('id', 'name')->get();
    }

    public static function getFacultiesForEdit()
    {
        return Faculty::select('id', 'name')->get();
    }

    public static function validate($data, $request)
    {
        $rules = $request->rules();

        $messages = $request->messages();

        return Validator::make($data, $rules, $messages);
    }

    public static function createMajor($data)
    {
        return self::create($data);
    }

    public static function findMajorById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateMajor($id, $data)
    {
        $major = self::findOrFail($id);
        $major->update($data);
        return $major;
    }

    public static function deleteMajor($id)
    {
        $major = self::findOrFail($id);
        $major->delete();
    }

    public static function getNameMajors()
    {
        return self::select('id', 'name')
        ->get();
    }

    public static function getNameMajorById($id)
    {
        return self::where('id', $id)
            ->select('id', 'name', 'faculty_id')
            ->firstOrFail();
    }

    public static function getMajorsWithFacultyId($id)
    {
        return self::where('faculty_id', $id)
            ->select('id', 'name')
            ->get();
    }

    public static function getAllMajors()
    {
        return self::with('students')
        ->get();
    }

}
