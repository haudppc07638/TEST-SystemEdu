<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrerequisiteSubject extends Model
{
    protected $fillable = [
        'subject_id',
        'prerequisite_id',
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function prerequisite()
    {
        return $this->belongsTo(Subject::class, 'prerequisite_id');
    }
}
