<?php

namespace Modules\Notifications\Entities;


use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';


    /**
     *
     * @return bool
     */
    static public function isRead($id)
    {
        $notification = Self::find($id);

        if ($notification->read_at != null) {
            return true;
        }
        return false;
    }


}
