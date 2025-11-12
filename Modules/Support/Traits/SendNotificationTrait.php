<?php


namespace Modules\Support\Traits;

use App\Notifications\SendNotification;
use App\Notifications\SendOfferNotification;
use Modules\Accounts\Entities\User;

trait SendNotificationTrait
{

    protected function sendNotification($request, $title, $message)
    {
        if ($request->audience == 'followers') {
            $vendor = Vendor::find($request->vendor_id);
            $_users = $vendor->followers->pluck('user_id')->toArray();
            $users = User::whereNotNull('device_token')->find($_users);
        } elseif ($request->audience == 'specific') {
            $users = User::whereNotNull('device_token')->find($request->users);
        } else {
            $users = User::whereNotNull('device_token')->get();
        }

        if ($users) {
            foreach ($users as $user) {
                $user->notify(new SendNotification($title, $message, $user->device_token));
            }
        }
    }

}
