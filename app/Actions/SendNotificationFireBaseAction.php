<?php
namespace App\Actions;

use Carbon\Carbon;
use Modules\Accounts\Entities\User;

class SendNotificationFireBaseAction
{
    public function handle(User $user, string $time, string $comment_message, User $sender)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::whereNotNull('device_token')->where('id',$user->id)->pluck('device_token')->all();
        
        $serverKey = 'AAAAwGf_-m4:APA91bEY2ISTK0yqCd_C8jkFS5n-BRVnzKBaOZ3KYHWr4M2cuFbEDgc9tPrelBo3eeuAR3C1wapC-DzTaB_WkLMuSFSWouyv-9uQKJ_nEZz4BDkl3Wk5xVovnw9GQCv2Ig-BXxu_SmOW';
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $user->full_name,
                "body" => $comment_message,
                

            ],
            "data" => [
                "sender_image" => asset($sender->avatar),
                "sender_name" => $sender->full_name,
                "time_sent" => Carbon::now()->toDateTimeString(),
            ]
        ];
        $encodedData = json_encode($data);
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
    }
}
