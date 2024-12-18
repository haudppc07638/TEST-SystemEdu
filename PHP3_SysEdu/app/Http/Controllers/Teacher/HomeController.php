<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('employee')->user();
        $notifications = Notification::getTeacherNotifications($teacher->major_id);
        dd($notifications);
        return view('teacher.home', compact('notifications'));
    }

    public function show(string $id)
    {
        $teacher = Auth::guard('employee')->user();
        $notification = Notification::with('employee')->findOrFail($id);

        return view('teacher.notifications.show', compact('notification'));
    }
}
