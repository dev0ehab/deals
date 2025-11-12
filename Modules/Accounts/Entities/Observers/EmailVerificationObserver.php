<?php


namespace Modules\Accounts\Entities\Observers;


use Modules\Accounts\Entities\User;

class EmailVerificationObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param User $user
     * @return void
     */
    public function saving(User $user)
    {
        if ($user->isDirty('phone')) {
            $user->forceFill(['email_verified_at' => null]);
        }

        if ($user->isDirty('email')) {
            $user->forceFill(['email_verified_at' => null]);
        }
    }

}
