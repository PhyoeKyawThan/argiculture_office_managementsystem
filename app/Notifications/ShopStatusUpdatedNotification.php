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

        $message = __($messageKey, ['shop' => $this->shop->name]);

        if ($this->shop->status === PesticideShop::STATUS_REJECTED && $this->shop->rejection_reason) {
            $message .= ' Reason: ' . $this->shop->rejection_reason . '.';
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
        $body = match ($this->shop->status) {
            PesticideShop::STATUS_APPROVED => 'Your pesticide shop registration has been approved. You can now download your license from the dashboard.',
            PesticideShop::STATUS_REJECTED => 'Your pesticide shop registration was rejected. Reason: ' . ($this->shop->rejection_reason ?: 'Please review and resubmit with corrected information.') . '.',
            default => 'Your pesticide shop registration status has been updated.',
        };

        return (new MailMessage)
            ->subject('Pesticide shop registration status update')
            ->greeting('Hello ' . ($notifiable->name ?? ''))
            ->line($body)
            ->action('View dashboard', route('shop.dashboard'))
            ->line('We will notify you again when there is another status change.');
    }
}
