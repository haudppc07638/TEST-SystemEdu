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

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::getAllFaculties();
        $notifications = Notification::getAllNotifications();
        foreach ($notifications as $notification) {
            // Định dạng ngày gửi theo định dạng 'H:i - d/m/Y'
            $notification->formatted_date_sent = Carbon::parse($notification->date_sent)->format('d/m/Y');
            // Xử lý dữ liệu recipients
            if (is_string($notification->recipient)) {
                $recipients = json_decode($notification->recipient, true);
            } else {
                $recipients = $notification->recipient;
            }
            // Chuyển đổi recipients thành chuỗi phân cách bằng dấu phẩy
            $notification->formatted_recipient = is_array($recipients) ? implode(', ', $recipients) : $recipients;
        }
        return view('admin.notifications.index', [
            'faculties' => $faculties,
            'notifications' => $notifications,
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
        $sendAt = \Carbon\Carbon::parse($notification->date_sent);

        // Lên lịch gửi thông báo qua email hoặc hệ thống
        if ($notification->type == 'email') {
            foreach ($recipients as $recipient) {
                // Tạo job và lên lịch gửi email
                SendNotificationJob::dispatch($notification, $recipient)->delay($sendAt);
            }
        } else {
            // Tạo job và lên lịch gửi thông báo hệ thống
            SendSystemNotificationJob::dispatch($notification)->delay($sendAt);
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
}
