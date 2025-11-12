<?php

namespace Modules\Notifications\Http\Controllers\Api;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Support\Traits\ApiTrait;
use Modules\Notifications\Transformers\NotificationsResource;

class NotificationsController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * Display a listing of the Notifications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate();

        $data = NotificationsResource::collection($notifications)->response()->getData(true);
        return $this->sendResponse($data, 'success');
    }

    public function read(Request $request)
    {
        $notification = auth()->user()->unreadNotifications->find($request->id);
        if ($notification) {
            $notification->markAsRead();
            $data = new NotificationsResource($notification);
            return $this->sendResponse($data, __('The notification is read successfully.'));
        }
        return $this->sendError(__('Sorry not found'));
    }

    public function readNotification(Request $request, User $user)
    {
        $notification = $user->unreadNotifications->find($request->id);
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

}
