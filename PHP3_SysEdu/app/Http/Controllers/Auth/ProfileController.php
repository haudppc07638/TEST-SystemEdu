<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profileEmployee(){
        $user = Auth::guard('employee')->user();
        return view('admin.profile', [
            'user' => $user
        ]);
    }
    public function profileStudent () {
        $user = Auth::guard('student')->user();
        $formatDate = Carbon::parse($user->created_at)->format('d/m/Y');
        return view('client.profile', [
            'user' => $user,
            'formatDate' => $formatDate
        ]);
    }
}
