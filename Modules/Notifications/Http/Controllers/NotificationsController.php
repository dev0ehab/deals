<?php

namespace Modules\Notifications\Http\Controllers;

use App\Enums\NotificationTypesEnum;
use App\Jobs\UserNotificationJob;
use App\Services\NotificationsService;
use DB;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Notifications\Entities\Notification;
use Modules\Notifications\Http\Requests\NotificationRequest;
use Modules\Support\Traits\paginateTrait;

class NotificationsController extends Controller
{
    use paginateTrait;
    private $service;

    public function __construct(NotificationsService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        auth()->user()->unreadNotifications->markAsRead();

        $readNotifications = auth()->user()->readNotifications;
        $readNotifications = $this->paginate($readNotifications, 10, null, ['path' => "notifications"]);
        return view('notifications::notifications.index', get_defined_vars());
    }


    public function create()
    {
        return view('notifications::notifications.create');
    }


    public function store(NotificationRequest $request)
    {
        if ($request->all == 1) {
            $users = User::whereDoesntHave("roles")->whereNotNull('device_token')->get();
        } else {
            $users = User::whereNotNull('device_token')->find($request->users);
        }


        if ($users) {
            dispatch(new UserNotificationJob([$users, NotificationTypesEnum::General->value, [$request->title], [$request->message] , null]));
        }

        if ($users) {
            foreach ($users as $user) {
                $this->service->handleNotification(NotificationTypesEnum::General->value, $user, [$request->title], [$request->message], null, false);
            }
        }

        flash(trans('notifications::notifications.messages.created'))->success();

        return redirect()->back();
    }


    public function destroy(Notification $notification)
    {
        $notification->delete();

        flash(trans('notifications::notifications.messages.deleted'))->error();

        return redirect()->route('dashboard.notifications.index');
    }
}
