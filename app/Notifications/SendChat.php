<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use dev0ehab\FcmHttpV1\FcmNotification;

class SendChat extends Notification
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
        return $this->data['recipient_type']::find($this->data['recipient_id'])->preferred_locale ?? 'en';
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
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
