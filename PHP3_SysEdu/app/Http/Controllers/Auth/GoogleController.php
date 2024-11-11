<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request){
        if ($request->routeIs('google.login.admin')) {
            session(['google_user_type' => 'admin']);
        } 
        else if ($request->routeIs('google.login.teacher')) {
            session(['google_user_type'=> 'teacher']);
        }
        else {
            session(['google_user_type' => 'student']);
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $userType = session('google_user_type');
        if ($userType == 'admin') {
            $user = Employee::where('email', $googleUser->getEmail())->where('position', 'admin')->first();
            
            if (!$user) {
                toastr()->error('Email bạn không có quyền đăng nhập trang này !');
                return redirect()->route('login');
            }
            Auth::guard('employee')->login($user);
        }
        else if ($userType == 'teacher') {
            $user = Employee::where('email', $googleUser->getEmail())->where('position', 'teacher')->first();
            if (!$user) {
                toastr()->error('Email bạn không có quyền đăng nhập trang này !');
                return redirect()->route('login');
            }
            Auth::guard('employee')->login($user);  
        }
        else if ($userType == 'student') {
            $user = Student::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                toastr()->error('Email bạn không có quyền đăng nhập trang này !');
                return redirect()->route('login');
            }
            Auth::guard('student')->login($user);
        }
        
        if ($user) {
            return redirect()->intended('/' . ($userType === 'admin' ? 'dashboard' : ($userType === 'teacher' ? 'gv' : 'trang-chu')));
        }
        toastr()->error('Email không có quyền truy cập !');
        return redirect()->route('login');
    }
}
