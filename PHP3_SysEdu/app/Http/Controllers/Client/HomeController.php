<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tuition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentSubjectClass;
use App\Models\TotalTuition;
class HomeController extends Controller
{
    public function index() {
        // $student = Auth::guard(name: 'student')->user();
        $tuition = Tuition::getSubjectStudentRegister();
        $totalTuition = TotalTuition::getTotal();
        return view('client.home',[
            'tuitionView' => $tuition,
            'totalTuitionView' => $totalTuition
    
    ]);
    }
    public function tuition($id){
        $studentSubjectClass = StudentSubjectClass::findOrFail($id);
        $tuition = Tuition::insertTuitionJoinClass($studentSubjectClass->id);
    
        return redirect()->route('tuition.success')->with('success', 'Tuition created successfully');
    }
}
