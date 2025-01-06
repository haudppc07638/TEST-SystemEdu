<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotificationRequest;
use App\Jobs\SendNotificationJob;
use App\Jobs\SendSystemNotificationJob;
use App\Mail\NotificationMail;
use App\Models\Employee;
use App\Models\Faculty;
use App\Models\Notification;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::getAllFaculties();
        $pendingNotifications = Notification::where('status', 'pending')->latest()->paginate(10);
        $sentNotifications = Notification::where('status', 'sent')->latest()->paginate(10);

        foreach ($pendingNotifications as $notification) {
            $notification->formatted_date_sent = Carbon::parse($notification->date_sent)->format('d/m/Y');
            $recipients = is_string($notification->recipients) ? json_decode($notification->recipients, true) : $notification->recipients;
            $notification->formatted_recipient = is_array($recipients) ? implode(', ', $recipients) : $recipients;
        }

        foreach ($sentNotifications as $notification) {
            $notification->formatted_date_sent = Carbon::parse($notification->date_sent)->format('d/m/Y');
            $recipients = is_string($notification->recipients) ? json_decode($notification->recipients, true) : $notification->recipients;
            $notification->formatted_recipient = is_array($recipients) ? implode(', ', $recipients) : $recipients;
        }

        return view('admin.notifications.index', [
            'faculties' => $faculties,
            'pendingNotifications' => $pendingNotifications,
            'sentNotifications' => $sentNotifications,
        ]);
    }

    public function send(NotificationRequest $request)
    {
        $rules = $request->rules();
        $messages = $request->messages();

        $data = $request->only('recipient_type', 'faculties', 'majors', 'type', 'title', 'content', 'date_sent');
        $dataValidator = $request->only('title', 'content', 'date_sent');

        $validator = Validator::make($dataValidator, $rules, $messages);
        if ($validator->stopOnFirstFailure()->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (empty($data['recipient_type'])) {
            toastr()->error('Vui lòng chọn đối tượng nhận');
            return redirect()->back()->withInput();
        }

        $recipients = [];

        // Xử lý thông báo cho sinh viên
        if ($data['recipient_type'] == 'students') {
            if (empty($data['majors'])) {
                toastr()->error('Vui lòng chọn chuyên ngành');
                return redirect()->back()->withInput();
            }
            $students = Student::getStudentsByMajors($data['majors']);
            $recipients = $students->pluck('email')->toArray(); // Lưu email sinh viên vào mảng

            // Lưu thông báo vào cơ sở dữ liệu
            // dd($data['majors']);
            $notification = Notification::createNotificationStudent(
                $data['title'],
                $data['content'],
                $data['type'],
                $data['date_sent'],
                Auth::guard('employee')->id(),
                $data['majors']
            );

            // Lên lịch gửi thông báo
            $this->dispatchNotification($recipients, $notification);
            toastr()->success('Thông báo đã được lên lịch gửi thành công');
        }


        // Xử lý thông báo cho giáo viên
        if ($data['recipient_type'] == 'teachers') {
            if (empty($data['faculties'])) {
                toastr()->error('Vui lòng chọn khoa');
                return redirect()->back()->withInput();
            }
            $teachers = Employee::getTeachersByFaculties($data['faculties']);
            $recipients = $teachers->pluck('email')->toArray(); // Lưu email giáo viên vào mảng

            // Lưu thông báo vào cơ sở dữ liệu
            $notification = Notification::createNotificationTeacher(
                $data['title'],
                $data['content'],
                $data['type'],
                $data['date_sent'],
                Auth::guard('employee')->id(),
                $data['faculties']
            );

            // Lên lịch gửi thông báo
            $this->dispatchNotification($recipients, $notification);
            toastr()->success('Thông báo đã được lên lịch gửi thành công');
        }

        return redirect()->route('admin.notifications.index');
    }

    private function dispatchNotification(array $recipients, Notification $notification)
    {
        $sendAt = Carbon::parse($notification->date_sent)->setTimezone(config('app.timezone'));
        $now = now()->setTimezone(config('app.timezone'));

        // Tính delay (lấy giá trị tối thiểu là 0 nếu delay âm)
        $delay = max($sendAt->diffInRealSeconds($now, false), 0);

        // Lên lịch gửi thông báo
        if ($notification->type == 'email') {
            foreach ($recipients as $recipient) {
                SendNotificationJob::dispatch($notification, $recipient)->delay($delay);
            }
        } else {
            SendSystemNotificationJob::dispatch($notification)->delay($delay);
        }
    }

    public function detail($id)
    {
        $notification = Notification::getNotificationById($id);
        $notification->formatted_date_sent = Carbon::parse($notification->date_sent)->format('H:i - d/m/Y');

        if (is_string($notification->recipient)) {
            $recipients = json_decode($notification->recipient, true);
        } else {
            $recipients = $notification->recipient;
        }

        // Chuyển đổi recipients thành một danh sách các giá trị
        $notification->recipients_list = is_array($recipients) ? $recipients : [];
        $notification->formatted_recipient = is_array($recipients) ? implode(', ', $recipients) : $recipients;

        return view('admin.notifications.detail', [
            'notification' => $notification
        ]);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            toastr()->error('Thông báo không tồn tại.');
            return redirect()->route('admin.notifications.index');
        }

        $notification->delete();

        toastr()->success('Xóa thành công thông báo: ' . $notification->title);
        return redirect()->route('admin.notifications.index');
    }
}
