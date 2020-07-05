<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

use DateTimeImmutable;
use Francken\Treasurer\DeductionEmail;
use Francken\Treasurer\DeductionEmailToMember;
use Francken\Treasurer\SendDeductionNotification;
use Illuminate\Contracts\Mail\Mailer;

final class DeductionEmailsController
{
    private Mailer $mail;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    public function create(DeductionEmail $deduction)
    {
        if ( ! $deduction->was_verified) {
            return redirect()->action([DeductionsController::class, 'show'], $deduction->id)
                ->with('error', 'Deductions must be verified before sending emails.');
        }

        if ($deduction->emails_sent_at !== null) {
            return redirect()->action([DeductionsController::class, 'show'], $deduction->id)
                ->with('error', 'Notifications have already been sent.');
        }

        $deduction->load([
            'deductionToMembers',
            'deductionToMembers.member'
        ]);

        $deduction->deductionToMembers->each(function (DeductionEmailToMember $member) : void {
            $email = $member->member->emailadres;

            $this->mail->to($email)
                ->queue(new SendDeductionNotification($member->id));
        });
        $deduction->emails_sent_at = new DateTimeImmutable();
        $deduction->save();

        return redirect()->action([DeductionsController::class, 'show'], $deduction->id)
            ->with('status', 'Deduction emails are being send');
    }
}
