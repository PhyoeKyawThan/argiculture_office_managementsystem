<?php

namespace App\Notifications;

use App\Models\FertilizerDistributionLicense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateFertilizerLicenseNotification extends Notification
{
    use Queueable;

    public function __construct(public FertilizerDistributionLicense $license) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'license_id' => $this->license->id,
            'shop_id' => $this->license->user->id,
            'shop_name' => $this->license->user->username,
            'owner_name' => $this->license->applicant_name,
            'message' => __('messages.notifications.update_fertilizer_license', [
                'shop' => $this->license->user->username,
                'owner' => $this->license->applicant_name,
            ], 'my'),
            'url' => route('admin.fertilizer-licenses.show', $this->license),
        ];
    }
}
