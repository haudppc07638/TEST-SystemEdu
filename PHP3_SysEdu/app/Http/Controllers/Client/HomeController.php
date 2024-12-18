<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $major = Major::find($student->major_id);

        $notifications = Notification::getStudentNotifications($major->id);

        return view('client.home', compact('notifications'));
    }

    public function show($id)
    {
        $notification = Notification::find($id);
        return view('client.detail-notification', compact('notification'));
    }

}
