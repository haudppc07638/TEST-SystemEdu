<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'block',
        'year',
    ];
    public function subjectClasses(): HasMany{
        return $this->hasMany(SubjectClass::class);
    }
    public static function getSemester()
    {
        return self::select('id', 'block')
        ->get();
    }
    public static function getAllSemester(){
        return self::select('id', 'block', 'year')
        ->orderBy('id', 'desc')
        ->get();
    }
}
