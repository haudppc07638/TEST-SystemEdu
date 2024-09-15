<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'title',
        'content',
        'type',
        'date_sent',
        'employee_id',
        'recipient',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public static function getAllNotifications(){
        return self::with('employee')
        ->orderBy('id', 'desc')
        ->get();
    }

    public static function getNotificationById($id){
        return self::with('employee')
        ->findOrFail($id);
    }

    public static function createNotificationStudent($title, $content, $type, $date_sent, $employeeId, $majorIds)
    {
        $majors = Major::whereIn('id', $majorIds)->pluck('name')->toArray();

        return self::create([
            'title' => $title,
            'content' => $content,
            'type' => $type,
            'date_sent' => $date_sent,
            'employee_id' => $employeeId,
            'recipient' => json_encode($majors),
        ]);
    }

    public static function createNotificationTeacher($title, $content, $type, $date_sent, $employeeId, $facultyIds)
    {
        $faculties = Faculty::whereIn('id', $facultyIds)->pluck('name')->toArray();

        return self::create([
            'title' => $title,
            'content' => $content,
            'type' => $type,
            'date_sent' => $date_sent,
            'employee_id' => $employeeId,
            'recipient' => json_encode($faculties),
        ]);
    }
}
