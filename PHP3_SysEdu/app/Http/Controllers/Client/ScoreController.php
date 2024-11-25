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

        // Fetch the current semester based on the date
        $currentSemester = Semester::where('start_date', '<=', $today)
                                   ->where('end_date', '>=', $today)
                                   ->first();

        // If no semester is found, return an error
        if (!$currentSemester) {
            return redirect()->back()->with('error', 'Không có kỳ học nào đang diễn ra.');
        }

        // Fetch the scores for the current student, filtered by current semester
        $scores = StudentSubjectClass::whereHas('subjectClass', function ($query) use ($currentSemester) {
            // Make sure we only retrieve classes for the current semester
            $query->where('semester_id', $currentSemester->id);
        })
        ->with('subjectClass.semester', 'subjectClass.subject')  // Eager load related data
        ->where('student_id', $user->id)  // Filter by the logged-in student
        ->paginate(10);  // Paginate the results

        return view('client.score', compact('scores', 'currentSemester', 'major'));
    }
}
