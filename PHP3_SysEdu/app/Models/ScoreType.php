<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScoreType extends Model
{
    protected $fillable = ['name', 'type'];

    public function subjectScoreTypes(): HasMany
    {
        return $this->hasMany(SubjectScoreType::class);
    }
}
