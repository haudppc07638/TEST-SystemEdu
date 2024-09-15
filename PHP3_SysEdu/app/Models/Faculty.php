<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;

class Faculty extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'faculties';
    protected $fillable = [
        'id',
        'name',
        'code',
        'dean',
        'assistant_dean',
        'description'
    ];

    public function majors(): HasMany
    {
        return $this->hasMany(Major::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
    public static function validate($data, $request)
    {
        $rules = $request->rules();

        $messages = $request->messages();

        return Validator::make($data, $rules, $messages);
    }
    protected static function getAllFaculty(){
        return self::select('id', 'name', 'code', 'description')
        ->orderBy('id', 'desc')
        ->get();
    }
    protected static function createFaculty($data){
        return self::create($data);
    }
    protected static function getFacultyId($id){
        return self::findOrFail($id);
    }
    protected static function updateFacultyId($id, $data){
        $facultyId = self::findOrFail($id);
        $facultyId->update($data);
        return $facultyId;
    }
    protected static function deleteFacultyId($id){
        return self::findOrFail($id)->delete();
    }
    public static function getNameFaculties()
    {
        return Faculty::select('id', 'name')
        ->paginate(8);
    }

    public static function getAllFaculties()
    {
        return Faculty::with('majors', 'employees')
        ->get();
    }

}
