<?php

namespace App\Notifications;

use App\Models\AgriculturalInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReplyFarmerInquiryNotification extends Notification
{
    use Queueable;

    public function __construct(public AgriculturalInquiry $inquiry, ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $this->inquiry->loadMissing('farmer:id,name');

        return [
            'inquiry_id' => $this->inquiry->id,
            'title' => $this->inquiry->title,
            'answered_by' => $this->inquiry->responder()->name,
            'message' => __('messages.notifications.response_farmer_inquiry', [
                'responder' => $this->inquiry->farmer->name,
                'title' => $this->inquiry->title,
            ]),
            'url' => route('admin.inquiries.show', $this->inquiry),
        ];
    }
}
