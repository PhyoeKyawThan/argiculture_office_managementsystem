<?php

namespace App\Notifications;

use App\Models\PesticideShop;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShopStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(public PesticideShop $shop, public string $previousStatus) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        $messageKey = match ($this->shop->status) {
            PesticideShop::STATUS_APPROVED => 'messages.notifications.shop_status_approved',
            PesticideShop::STATUS_REJECTED => 'messages.notifications.shop_status_rejected',
            default => 'messages.notifications.shop_status_updated',
        };

        $message = __($messageKey, ['shop' => $this->shop->name], 'my');

        if ($this->shop->status === PesticideShop::STATUS_REJECTED && $this->shop->rejection_reason) {
            $message .= ' အကြောင်းပြချက် : ' . $this->shop->rejection_reason . '.';
        }

        return [
            'shop_id' => $this->shop->id,
            'shop_name' => $this->shop->name,
            'owner_name' => $this->shop->owner_name,
            'message' => $message,
            'previous_status' => $this->previousStatus,
            'status' => $this->shop->status,
            'rejection_reason' => $this->shop->rejection_reason,
            'url' => route('shop.dashboard'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $body = __($this->matchStatusMessageKey(), ['shop' => $this->shop->name], 'my');

        if ($this->shop->status === PesticideShop::STATUS_REJECTED && $this->shop->rejection_reason) {
            $body .= ' အကြောင်းပြချက် : ' . $this->shop->rejection_reason . '.';
        }
        if ($this->shop->status === PesticideShop::STATUS_APPROVED){
            $body .= 'တစ်လအတွင်း ကွင်းဆင်းစစ်ဆေးပါမည်။ကွင်းဆင်းစစ်ဆေးမှု့အောင်မြင်ပါက လိုင်စင်ထုတ်ပေးပါမည်။';
        }

        return (new MailMessage)
            ->subject('ပိုးသတ်ဆေးဆိုင် မှတ်ပုံတင်ခြင်း အခြေအနေ အပ်ဒိတ်')
            ->greeting('မင်္ဂလာပါ ' . ($notifiable->name ?? ''))
            ->line($body)
            ->line('အခြေအနေ အပြောင်းအလဲ တစ်စုံတစ်ရာ ရှိပါက ထပ်မံ အကြောင်းကြားပါမည်။');
    }

    private function matchStatusMessageKey(): string
    {
        return match ($this->shop->status) {
            PesticideShop::STATUS_APPROVED => 'messages.notifications.shop_status_approved',
            PesticideShop::STATUS_REJECTED => 'messages.notifications.shop_status_rejected',
            default => 'messages.notifications.shop_status_updated',
        };
    }
}