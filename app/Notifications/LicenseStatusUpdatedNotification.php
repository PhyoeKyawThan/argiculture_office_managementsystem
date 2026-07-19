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
            FertilizerDistributionLicense::STATUS_SENDING_TO_REGIONAL_DEPARTMENT => 'Your fertilizer distribution license is being transferred from the Township Department to the Regional Department.',
            FertilizerDistributionLicense::STATUS_CANCELLED => 'Your fertilizer distribution license application was cancelled. Please review and resubmit with corrected information.',
            default => 'Your fertilizer distribution license status has been updated.',
        };

        if ($this->license->status === FertilizerDistributionLicense::STATUS_CANCELLED && $this->license->cancelled_reason) {
            $message .= ' Reason: ' . $this->license->cancelled_reason;
        }

        return [
            'license_id' => $this->license->id,
            'title' => 'Fertilizer distribution license status updated',
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
            FertilizerDistributionLicense::STATUS_SENDING_TO_REGIONAL_DEPARTMENT => 'Your fertilizer distribution license is being transferred from the Township Department to the Regional Department.',
            FertilizerDistributionLicense::STATUS_CANCELLED => 'Your fertilizer distribution license application was cancelled. Reason: ' . ($this->license->cancelled_reason ?: 'Please review and resubmit with corrected information.'),
            default => 'Your fertilizer distribution license status has been updated.',
        };

        return (new MailMessage)
            ->subject('Fertilizer distribution license status update')
            ->greeting('Hello ' . ($notifiable->name ?? ''))
            ->line($body)
            ->action('View dashboard', route('shop.dashboard'))
            ->line('We will notify you again when there is another status change.');
    }
}