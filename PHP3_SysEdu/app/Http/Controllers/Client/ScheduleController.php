<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('student')->user();

        $timeRange = $request->get('time_range', '7 days ahead');
        $startDate = now();
        $endDate = now();

        switch ($timeRange) {
            case '7 days ahead':
                $endDate = now()->addDays(7);
                break;
            case '14 days ahead':
                $endDate = now()->addDays(14);
                break;
            case '30 days ahead':
                $endDate = now()->addDays(30);
                break;
            case '60 days ahead':
                $endDate = now()->addDays(60);
                break;
            case '90 days ahead':
                $endDate = now()->addDays(90);
                break;
            case '7 days before':
                $startDate = now()->subDays(7);
                break;
            case '14 days before':
                $startDate = now()->subDays(14);
                break;
            case '30 days before':
                $startDate = now()->subDays(30);
                break;
            case '60 days before':
                $startDate = now()->subDays(60);
                break;
            case '90 days before':
                $startDate = now()->subDays(90);
                break;
        }

        $schedules = Schedule::whereExists(function ($query) use ($user) {
            $query->select(DB::raw(1))
                ->from('subject_classes')
                ->whereColumn('schedules.subject_class_id', 'subject_classes.id')
                ->whereExists(function ($query) use ($user) {
                    $query->select(DB::raw(1))
                        ->from('student_subject_classes')
                        ->whereColumn('subject_classes.id', 'student_subject_classes.subject_class_id')
                        ->where('student_id', $user->id);
                });
        })
            ->whereBetween('schedule_day', [$startDate, $endDate])
            ->paginate(10);

        return view('client.schedule', compact('schedules'));
    }
}
