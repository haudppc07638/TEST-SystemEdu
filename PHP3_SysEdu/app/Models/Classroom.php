<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'location', 
        'capacity',
    ];
    public function Schedule(): BelongsTo{
        return $this->belongsTo(Schedule::class);
    }

    public function scheduleHistories()
    {
        return $this->hasMany(ScheduleHistory::class);
    }

}
