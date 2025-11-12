<?php

namespace App\Console\Commands;

use App\Enums\NotificationTypesEnum;
use App\Jobs\UserNotificationJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewCouponNotification;
use Modules\Accounts\Entities\User;
use Modules\Coupons\Entities\Coupon;

class CouponNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new coupons and notify users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all coupons
        $todayCoupons = Coupon::whereDate('start_at' , today())->get();

        // // coupons starting today
        // $todayCoupons = $coupons->filter(function ($coupon) {
        //     return $coupon->start_at->isToday();
        // });

        if ($todayCoupons->isEmpty()) {
            $this->info('No new coupons for today.');
            return 0;
        }

        $this->info('New coupons for today: ' . $todayCoupons->count());


        foreach ($todayCoupons as $coupon) {
            $users = User::whereIn('id' , $coupon->users)->get();
            dispatch(new UserNotificationJob([$users, NotificationTypesEnum::NewCoupon->value, ["coupons::coupons.messages.new_title"], ["coupons::coupons.messages.new_body", ['code' => $coupon->code]], $coupon]));
        }

        $this->info('Notifications for new coupons have been sent.');
        return 0;
    }
}
