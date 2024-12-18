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
        'recipients',
        'status',
    ];

    protected $casts = [
        'recipients' => 'array',
        'date_sent' => 'datetime'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // public static function getAllNotifications(){
    //     return self::with('employee')
    //     ->get();
    // }

    public static function getNotificationById($id)
    {
        return self::with('employee')
            ->findOrFail($id);
    }

    public static function createNotificationStudent($title, $content, $type, $date_sent, $employeeId, $majorIds)
    {
        $majors = Major::whereIn('id', $majorIds)->pluck(column: 'name')->toArray();
        // dd($majors);
        return self::create([
            'title' => $title,
            'content' => $content,
            'type' => $type,
            'date_sent' => $date_sent,
            'employee_id' => $employeeId,
            'recipients' => $majors,
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
            'recipients' => $faculties,
        ]);
    }

    public static function getTeacherNotifications($majorId)
    {
        $major = Major::find($majorId);
        $faculty = Faculty::find($major->faculty_id);

        return self::with('employee')
            ->where('type', 'system')
            ->whereJsonContains('recipients', $faculty->name)
            ->orderBy('date_sent', 'desc')
            ->paginate(10);
    }

    public static function getStudentNotifications($majorId)
    {
        $major = Major::find($majorId);

        return self::with('employee')
            ->where('type', 'system')
            ->where('status', 'sent')
            ->whereJsonContains('recipients', $major->name)
            ->orderBy('date_sent', 'desc')
            ->paginate(10);
    }
}
