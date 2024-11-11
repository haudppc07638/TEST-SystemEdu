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
    
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'teacher_free_slots', 'time_slot_id', 'employee_id');
    }

    public function scheduleHistories()
    {
        return $this->hasMany(ScheduleHistory::class);
    }

}
