<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\TotalTuition;
use App\Models\Student;
use App\Models\Semester;
use Illuminate\Http\Request;

class HistoryPaymentController extends Controller
{
    public function index(Request $request)
{
    $paymentStatus = $request->input('payment_status', null);

    $currentSemester = Semester::current()->first();

    $studentsQuery = Student::query()
    ->with(['totalTuition', 'studentSubjectClasses.subjectClass.semester'])
    ->whereHas('studentSubjectClasses.subjectClass', function ($query) use ($currentSemester) {
        $query->where('semester_id', $currentSemester->id);
    })
    ->whereHas('totalTuition') // Ensure totalTuition exists
    ->when($paymentStatus, function ($query) use ($paymentStatus) {
        $query->whereHas('totalTuition', function ($q) use ($paymentStatus) {
            $q->where('payment_status', $paymentStatus);
        });
    });

    $students = $studentsQuery->paginate(10);

    return view('client.history-payment', [
        'students' => $students,
        'paymentStatus' => $paymentStatus,
        'currentSemester' => $currentSemester,
    ]);
}


}
