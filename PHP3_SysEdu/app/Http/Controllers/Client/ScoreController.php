<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\StudentSubjectClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\SubjectScoreType;

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

    if (!$currentSemester) {
        return redirect()->back()->with('error', 'Không có kỳ học nào đang diễn ra.');
    }

    $studentSubjectClasses = StudentSubjectClass::whereHas('subjectClass', function ($query) use ($currentSemester) {
        $query->where('semester_id', $currentSemester->id);
    })
    ->with([
        'subjectClass.semester',
        'subjectClass.subject',
        'scores.subjectScoreType'
    ])
    ->where('student_id', $user->id)
    ->paginate(10);

   $subjectScoreTypes = SubjectScoreType::with('scoreType')
   ->whereIn('subject_id', $studentSubjectClasses->pluck('subjectClass.subject_id')->unique()) // Lọc theo môn học sinh viên đang học
   ->get();

    return view('client.score', [
        'subjectScoreTypes' => $subjectScoreTypes,
        // 'subjects' => $subjects,
        'studentSubjectClasses' => $studentSubjectClasses,
        'currentSemester' => $currentSemester,
        'major' => $major,
    ]);
}

}
