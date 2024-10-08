<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\StudentSubjectClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    public function index()
    {
        $user = Auth::guard('student')->user();
        $major = $user->major;
        $today = Carbon::today();

        $currentSemester = Semester::where('start_day', '<=', $today)
                                   ->where('end_day', '>=', $today)
                                   ->first();

        if (!$currentSemester) {
            return redirect()->back()->with('error', 'Không có kỳ học nào đang diễn ra.');
        }
        $scores = StudentSubjectClass::whereHas('subjectClass', function ($query) use ($currentSemester) {
            $query->where('semester_id', $currentSemester->id);
        })
        ->with('subjectClass.semester', 'subjectClass.subject')
        ->where('student_id', $user->id)
        ->paginate(10);

        return view('client.score', compact('scores', 'currentSemester', 'major'));
    }
}
