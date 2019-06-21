<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

// use Francken\Treasurer\Transaction;
use Francken\Treasurer\DeductionEmail;
use Francken\Treasurer\DeductionEmailToMember;
use Illuminate\Mail\Mailable;

final class DeductionMembersController
{
    public function show(DeductionEmail $deduction, int $member_id)
    {
        $member = $deduction->deductionToMembers
            ->first(function (DeductionEmailToMember $member) use ($member_id) {
                return $member->member_id === $member_id;
            });

        return new class($deduction, $member) extends Mailable {
            public function __construct($deduction, $member)
            {
                $this->date = $deduction->deducted_at->format('Y-m-d');
                $this->amount = $member->amount;
                $this->deduction = $deduction;
                $this->description = $member->description;
                $this->name = $member->member->fullname;
            }

            public function build()
            {
                return $this->markdown('auth.mails.deduction')->with([
                    'subject' => 'Deduction',
                    'email' => 'markredeman@gmail.com',

                    'name' => $this->name,
                    'description' => $this->description,
                    'date' => $this->date,
                    'deduction_amount' => $this->amount,
                    'subject' => 'Incasso ' . $this->date,
                ]);
            }
        };
    }
}
