<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'slot',
        'start_time',
        'end_time',
    ];
    public function Schedule(): HasMany{
        return $this->hasMany(Schedule::class);
    }
    ///
}
