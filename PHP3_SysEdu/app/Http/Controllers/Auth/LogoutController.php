<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logoutStudent(Request $request)
    {
        Auth::guard('student')->logout();

        // Xóa session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logoutEmployee(Request $request)
    {
        Auth::guard('employee')->logout();

        // Xóa session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
