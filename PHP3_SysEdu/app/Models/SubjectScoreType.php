<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectScoreType extends Model
{
    use SoftDeletes;

    protected $fillable = ['subject_id', 'score_type_id', 'weight', 'name'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function scoreType(): BelongsTo
    {
        return $this->belongsTo(ScoreType::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    } //

    public static function getScoreTypesForSubjectClass($subject_id)
    {
        return self::where('subject_id', $subject_id)->with('scoreType')->get();
    }
}
