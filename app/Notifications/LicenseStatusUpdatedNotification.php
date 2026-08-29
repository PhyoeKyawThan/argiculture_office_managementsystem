<?php

namespace App\Notifications;

use App\Models\FertilizerDistributionLicense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public FertilizerDistributionLicense $license,
        public string $previousStatus,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        $this->license->loadMissing('items');

        $message = match ($this->license->status) {
            FertilizerDistributionLicense::STATUS_SENDING_TO_REGIONAL_DEPARTMENT => 'သင့်၏ ဓာတ်မြေသြဇာ ဖြန့်ဖြူးရောင်းချခွင့် လိုင်စင်ကို မြို့နယ်ဦးစီးဌာနမှ တိုင်းဒေသကြီးဦးစီးဌာနသို့ လွှဲပြောင်းပေးပို့နေပါပြီ။',
            FertilizerDistributionLicense::STATUS_CANCELLED => 'သင့်၏ ဓာတ်မြေသြဇာ ဖြန့်ဖြူးရောင်းချခွင့် လိုင်စင် လျှောက်ထားမှု ပယ်ဖျက်ခံရပါသည်။ ကျေးဇူးပြု၍ ပြန်လည်စစ်ဆေးပြီး မှန်ကန်သော အချက်အလက်များဖြင့် ပြန်လည်တင်ပြပါ။',
            default => 'သင့်၏ ဓာတ်မြေသြဇာ ဖြန့်ဖြူးရောင်းချခွင့် လိုင်စင် အခြေအနေ ပြောင်းလဲသွားပါသည်။',
        };

        if ($this->license->status === FertilizerDistributionLicense::STATUS_CANCELLED && $this->license->cancelled_reason) {
            $message .= ' ပယ်ဖျက်ရသည့် အကြောင်းရင်း: ' . $this->license->cancelled_reason;
        }

        return [
            'license_id' => $this->license->id,
            'title' => 'ဓာတ်မြေသြဇာ ဖြန့်ဖြူးရောင်းချခွင့် လိုင်စင် အခြေအနေ ပြောင်းလဲခြင်း',
            'message' => $message,
            'previous_status' => $this->previousStatus,
            'status' => $this->license->status,
            'cancelled_reason' => $this->license->cancelled_reason,
            'item_count' => $this->license->items->count(),
            'url' => route('shop.dashboard'),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $body = match ($this->license->status) {
            FertilizerDistributionLicense::STATUS_SENDING_TO_REGIONAL_DEPARTMENT => 'သင့်၏ ဓာတ်မြေသြဇာ ဖြန့်ဖြူးရောင်းချခွင့် လိုင်စင်ကို မြို့နယ်ဦးစီးဌာနမှ တိုင်းဒေသကြီးဦးစီးဌာနသို့ လွှဲပြောင်းပေးပို့နေပါပြီ။',
            FertilizerDistributionLicense::STATUS_CANCELLED => 'သင့်၏ ဓာတ်မြေသြဇာ ဖြန့်ဖြူးရောင်းချခွင့် လိုင်စင် လျှောက်ထားမှု ပယ်ဖျက်ခံရပါသည်။ ပယ်ဖျက်ရသည့် အကြောင်းရင်း: ' . ($this->license->cancelled_reason ?: 'ကျေးဇူးပြု၍ ပြန်လည်စစ်ဆေးပြီး မှန်ကန်သော အချက်အလက်များဖြင့် ပြန်လည်တင်ပြပါ။'),
            default => 'သင့်၏ ဓာတ်မြေသြဇာ ဖြန့်ဖြူးရောင်းချခွင့် လိုင်စင် အခြေအနေ ပြောင်းလဲသွားပါသည်။',
        };

        return (new MailMessage)
            ->subject('ဓာတ်မြေသြဇာ ဖြန့်ဖြူးရောင်းချခွင့် လိုင်စင် အခြေအနေ အပ်ဒိတ်')
            ->greeting('မင်္ဂလာပါ ' . ($notifiable->name ?? ''))
            ->line($body)
            ->line('လိုင်စင် အခြေအနေ ထပ်မံပြောင်းလဲသည့်အခါ ထပ်မံ အကြောင်းကြားပေးပါမည်။');
    }
}