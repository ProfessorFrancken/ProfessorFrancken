<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

// use Francken\Treasurer\Transaction;
use Francken\Treasurer\DeductionEmail;
use Francken\Treasurer\DeductionEmailToMember;
use Francken\Treasurer\SendDeductionNotification;

final class DeductionMembersController
{
    public function show(DeductionEmail $deduction, int $memberId) : SendDeductionNotification
    {
        $member = $deduction->deductionToMembers
            ->first(function (DeductionEmailToMember $member) use ($memberId) : bool {
                return (int)$member->member_id === $memberId;
            });

        if ($member === null) {
            abort(404);
        }

        return new SendDeductionNotification($member->id);
    }
}
