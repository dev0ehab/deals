<?php

namespace App\Services;

use App\Enums\NotificationTypesEnum;
use Locales;
use App\Notifications\SendChat;

class ChatService
{
    private $data, $recipient, $type, $title, $message, $model;


    public function getTitle(): array
    {
        $title = $this->title[0];
        foreach (Locales::get() as $locale) {
            $data[$locale->code] = __($title, data_get($this->title, 1, []), $locale->code);
        }

        return $data;
    }


    public function getBody(): array
    {
        $message = $this->message[0];
        foreach (Locales::get() as $locale) {
            $data[$locale->code] = __($message, data_get($this->message, 1, []), $locale->code);
        }

        return $data;
    }

    /**
     * Get the sender of the notification based on the given type.
     *
     * @return array
     */
    public function getSender(): array
    {
        return [
            'type' => auth()->user()?->getMorphClass(),
            'id' => auth()->user()?->id,
            'name' => auth()->user()?->name,
            'image' => auth()->user()?->getAvatar(),
        ];
    }

    /**
     * Get the recipient of the notification based on the given type and recipient's id.
     *
     * @return array
     */
    public function getRecipient(): array
    {
        return [
            'type' => $this->recipient->getMorphClass(),
            'id' => $this->recipient->id,
        ];
    }

    /**
     * Get the target of the notification based on the given type and model.
     *
     * @return array
     */
    public function getTarget(): array
    {
        return [
            'type' => is_null($this->model) ? 'none' : $this->model->getMorphClass(),
            'id' => is_null($this->model) ? 'none' : $this->model->id,
        ];
    }



    public function getUrl()
    {
        return NotificationTypesEnum::NotificationUrl($this->type, $this->model?->id);
    }



    /**
     * handleNotification function
     *
     * This function is used to handle the notifications
     *
     * @param string $type The type of the notification
     * @param object $recipient The recipient of the notification
     * @param object $request The request object
     * @param object $model The model object
     *
     * @return void
     */
    public function handleNotification($type, $recipient, $title, $message, $model = null): void
    {
        $this->type = $type;
        $this->recipient = $recipient;
        $this->model = $model;
        $this->title = $title;
        $this->message = $message;

        $this->data = [
            'title'          => $this->getTitle(),
            'message'        => $this->getBody(),
            'fcmTokens'      => $recipient->device_token,
            'type'           => $type,
            'target_type'    => $this->getTarget()['type'],
            'target_id'      => (string) $this->getTarget()['id'],
            'sender_type'    => $this->getSender()['type'],
            'sender_id'      => (string) $this->getSender()['id'],
            'sender_name'    => $this->getSender()['name'],
            'sender_image'   => $this->getSender()['image'] ?? "https://www.gravatar.com/avatar/454141dab8fba2c55bc2d81247a629a4?d=mm",
            'recipient_type' => $this->getRecipient()['type'],
            'recipient_id'   => (string) $this->getRecipient()['id'],
            'url'            => $this->getUrl(),
        ];

        $this->send();
    }


    /**
     * send function
     *
     * This function is used to send the notification
     *
     * @return void
     */
    public function send(): void
    {
        $this->recipient->notify(new SendChat($this->data));
    }
}
