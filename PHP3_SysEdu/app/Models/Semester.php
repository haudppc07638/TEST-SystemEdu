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
        'start_date', 
        'end_date'
    ];
    public function isCurrentSemester()
    {
        $currentDate = \Carbon\Carbon::now();
        return $currentDate->between($this->start_date, $this->end_date);
    }
    public function scopeCurrent($query)
    {
    return $query->where('start_date', '<=', now())
                 ->where('end_date', '>=', now());
    }
    public function subjectClasses(): HasMany{
        return $this->hasMany(SubjectClass::class);
    }
    public static function getSemester()
    {
        return self::select('id', 'block', 'year')
        ->get();
    }
        public static function getAllSemester(){
        return self::select('id', 'block', 'year')
        ->orderBy('id', 'desc')
        ->get();
    }
}
