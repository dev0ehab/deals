<?php

namespace Modules\Accounts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendPasswordNotification extends Notification
{
    use Queueable;

    private $password;

    /**
     * Create a new notification instance.
     *
     * @param $password
     */
    public function __construct($password)
    {
        $this->password = $password;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting(trans('accounts::auth.emails.new-account-password.greeting', [
                'user' => $notifiable->name,
            ]))
            ->subject(trans('accounts::auth.emails.new-account-password.subject'))
            ->line(trans('accounts::auth.emails.new-account-password.email', [
                'email' => $notifiable->email,

            ]))
            ->line(trans('accounts::auth.emails.new-account-password.password', [
                'password' => $this->password,

            ]))
            ->line(trans('accounts::auth.emails.new-account-password.footer'))
            ->salutation(trans('accounts::auth.emails.new-account-password.salutation', [
                'app' => Config::get('app.name'),
            ]));
    }
}
