<?php

namespace Modules\Settings\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laraeast\LaravelSettings\Facades\Settings;


class SubscribeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->subject = Settings::get('subscribe_mail_subject');
        $this->content = Settings::get('subscribe_mail_message');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('settings::mails.show');
    }
}
