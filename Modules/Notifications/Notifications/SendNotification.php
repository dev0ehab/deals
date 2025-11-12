<?php

namespace Modules\Notifications\Notifications;

use dev0ehab\FcmHttpV1\FcmNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Orders\Events\DashboardNotificationEvent;


class SendNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

    }


    public function getPreferredLocale(): string
    {
        return $this->data['recipient_type']::find($this->data['recipient_id'])?->preferred_locale ?? app()->getLocale() ?? 'ar';
    }

    public function getRecipient()
    {
        return $this->data['recipient_type']::find($this->data['recipient_id']);
    }



    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $recipient = $this->getRecipient();
        $model = $this->data['target_type'];
        // dd($recipient->isVendor());

        if ($recipient->isAdmin() || $recipient->isVendor()) {
            event(new DashboardNotificationEvent($this->data));
        }

        if (is_null($this->data['fcmTokens']) || !canGetNotifications($recipient, $model)) {
            return ['database'];
        }
        return ['database', 'firebase'];
    }



    public function toFirebase($notifiable)
    {
        $this->data = array_merge($this->data, ['notification_id' => $this->id]);

        return (new FcmNotification())
            ->setTitle($this->data['title'][$this->getPreferredLocale()])
            ->setBody($this->data['message'][$this->getPreferredLocale()])
            ->setImage($this->data['sender_image'])
            ->setToken($this->data['fcmTokens'])
            ->setAdditionalData(array_slice($this->data, 3))
            ->send();

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->data;
    }
}
