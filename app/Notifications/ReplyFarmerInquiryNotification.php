<?php

namespace App\Notifications;

use App\Models\AgriculturalInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReplyFarmerInquiryNotification extends Notification
{
    use Queueable;

    public function __construct(public AgriculturalInquiry $inquiry) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $this->inquiry->loadMissing(['farmer:id,name', 'responder:id,name']);

        $responderName = $this->inquiry->responder?->name ?? 'Agriculture Office';

        return [
            'inquiry_id' => $this->inquiry->id,
            'title' => $this->inquiry->title,
            'responder_name' => $responderName,
            'message' => __('messages.notifications.inquiry_replied', [
                'responder' => $responderName,
                'title' => $this->inquiry->title,
            ]),
            'url' => route('farmer.inquiries.show', $this->inquiry),
        ];
    }
}
