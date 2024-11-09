<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  
// use App\Http\Requests\User\LoginRequest;     
use Illuminate\Support\Facades\Auth; 
class LoginController extends Controller
{
    public function index()
    {
        return view('auth.loginPortal');
    }
    public function loginAdmin(){
        return view('auth.employee');
    }
    public function loginStudent(){
        return view('auth.student');
    }
    public function loginTeacher(){
        return view('auth.teacher');
    }
}
