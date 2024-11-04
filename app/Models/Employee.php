<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public static function getTeachersByFaculties($facultyId)
    {
        return self::whereHas('major', function($query) use ($facultyId) {
                   $query->where('faculty_id', $facultyId);
               })
               ->where('position', 'teacher')
               ->get();
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
} 