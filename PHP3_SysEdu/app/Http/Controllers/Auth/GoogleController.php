<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Employee;
use App\Models\Student;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request){
        if ($request->routeIs('auth.google.employee')) {
            session(['google_user_type' => 'employee']);
        } else {
            session(['google_user_type' => 'student']);
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        $googleUser = Socialite::driver('google')->user();
        $userType = session('google_user_type');

        if ($userType === 'employee') {
            $employee = Employee::where('email', $googleUser->getEmail())->first();
            if ($employee) {
                Auth::guard('employee')->login($employee);
                return redirect()->route('admin.dashboard');
            }
        } elseif ($userType === 'student') {
            $student = Student::where('email', $googleUser->getEmail())->first();
            if ($student) {
                Auth::guard('student')->login($student);
                return redirect()->route('home');
            }
        }

        return redirect()->route('auth.'.$userType)->withErrors(['message' => 'Tài khoản không tồn tại']);
    }
}
