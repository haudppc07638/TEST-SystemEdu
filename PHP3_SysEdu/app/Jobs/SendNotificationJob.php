<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use App\Models\Notification;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;
    protected $recipient;

    public function __construct(Notification $notification, $recipient)
    {
        $this->notification = $notification;
        $this->recipient = $recipient;
    }

    public function handle()
    {
        $notification = $this->notification;
        $recipient = $this->recipient;

        $senderEmail = $notification->employee->email;
        $senderName = $notification->employee->fullname;
        Mail::to($recipient)->send(new NotificationMail($notification->title, $notification->content, $senderEmail, $senderName));
    }
}
