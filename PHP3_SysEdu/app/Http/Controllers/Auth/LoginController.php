<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;  
// use App\Http\Requests\User\LoginRequest;     
use Illuminate\Support\Facades\Auth; 
class LoginController extends Controller
{
    public function loginEmployee(){
        return view('auth.employee');
    }
    public function loginStudent(){
        return view('auth.student');
    }
    // public function loginForm(LoginRequest $request){
    //     $request->validate([
    //         'email' => 'required|string|email|max:255',
    //         'password' => 'required|string',
    //     ]);
    //     return redirect()->route('admin.dashboard');
    // }
}
