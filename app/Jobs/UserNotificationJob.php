<?php

namespace App\Jobs;

use App\Services\NotificationsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private NotificationsService $service;
    private $users;

    private $notification_type;
    private $title;
    private $body;
    private $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data_array)
    {
        [
            $this->users,
            $this->notification_type,
            $this->title,
            $this->body,
            $this->model
        ]
            = $data_array;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = new NotificationsService();

        foreach ($this->users as $user) {
            $service->handleNotification($this->notification_type, $user, $this->title, $this->body, $this->model, false);
        }

    }
}
