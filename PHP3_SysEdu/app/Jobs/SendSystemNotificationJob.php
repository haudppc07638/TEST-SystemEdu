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
        try {
            $this->notification->update(['status' => 'sent']);
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }

    public function failed(\Exception $exception)
    {
        // Cập nhật trạng thái thành 'failed' nếu job thất bại
        $this->notification->update(['status' => 'failed']);
        toastr()->error('Gửi thông báo thất bại, vui lòng thử lại sau !');
    }
}
