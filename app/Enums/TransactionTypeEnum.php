<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;


enum TransactionTypeEnum: string
{
    use InteractWithEnum;

    case Deposit = "deposit";
    case PendingWithdraw = "pending_withdraw";
    case AcceptedWithdraw = "accepted_withdraw";
    case RejectedWithdraw = "rejected_withdraw";

    public static function colors($status)
    {
        $colors = [
            self::Deposit->value => "#17a2b8",
            self::PendingWithdraw->value => "#ffc107",
            self::AcceptedWithdraw->value => "#28a745",
            self::RejectedWithdraw->value => "#dc3545",
        ];

        return $colors[$status];
    }

    public static function translatedName($status)
    {
        return trans("deliveries::deliveries.transactions." . $status);
    }
}
