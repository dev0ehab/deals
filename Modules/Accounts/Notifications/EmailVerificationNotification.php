<?php

namespace Modules\Accounts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Modules\Accounts\Entities\Verification;

class EmailVerificationNotification extends Notification
{
    use Queueable;

    /**
     * @var string|int
     */
    private $code;
    private $email;

    /**
     * Create a new notification instance.
     *
     * @param $code
     */
    public function __construct($code, $email = null)
    {
        $this->code = $code;
        $this->email = $email;
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting(trans('accounts::auth.emails.password-less.greeting', [
                'user' => $this->email ?? $notifiable->email,
            ]))
            ->subject(trans('accounts::auth.emails.password-less.subject'))
            ->line(trans('accounts::auth.emails.password-less.line', [
                'code' => $this->code,
            ]))
            ->line(trans('accounts::auth.emails.password-less.time', [
                'minutes' => Verification::EXPIRE_DURATION / 60,
            ]))
            ->line(trans('accounts::auth.emails.password-less.footer'))
            ->salutation(trans('accounts::auth.emails.forget-password.salutation', [
                'app' => Config::get('app.name'),
            ]));
    }
}
