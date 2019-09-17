<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

// use Francken\Treasurer\Transaction;
use Francken\Treasurer\DeductionEmail;
use Francken\Treasurer\DeductionEmailToMember;
use Francken\Treasurer\SendDeductionNotification;

final class DeductionMembersController
{
    public function show(DeductionEmail $deduction, int $member_id)
    {
        $member = $deduction->deductionToMembers
            ->first(function (DeductionEmailToMember $member) use ($member_id) {
                return (int)$member->member_id === $member_id;
            });

        if ($member === null) {
            abort(404);
        }

        return new SendDeductionNotification($member->id);
    }
}
