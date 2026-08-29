<?php

namespace App\Notifications;

use App\Models\PesticideShop;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateShopRegistrationNotification extends Notification
{
    use Queueable;

    public function __construct(public PesticideShop $shop) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'shop_id' => $this->shop->id,
            'shop_name' => $this->shop->shop_name,
            'owner_name' => $this->shop->owner_name,
            'message' => __('messages.notifications.update_shop_registration', [
                'shop' => $this->shop->shop_name,
                'owner' => $this->shop->owner_name,
            ], 'my'),
            'url' => route('admin.pesticide-shops.show', $this->shop),
        ];
    }
}
