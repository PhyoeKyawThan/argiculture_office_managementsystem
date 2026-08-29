<?php

namespace App\Notifications;

use App\Models\AgriculturalInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewFarmerInquiryNotification extends Notification
{
    use Queueable;

    public function __construct(public AgriculturalInquiry $inquiry) {}

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
            'farmer_name' => $this->inquiry->farmer->name,
            'message' => __('messages.notifications.new_farmer_inquiry', [
                'farmer' => $this->inquiry->farmer->name,
                'title' => $this->inquiry->title,
            ], 'my'),
            'url' => route('admin.inquiries.show', $this->inquiry),
        ];
    }
}
