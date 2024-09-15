<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;

class SendSystemNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function handle()
    {
        $notification = $this->notification;
        // Xử lý gửi thông báo hệ thống tại đây
    }
}