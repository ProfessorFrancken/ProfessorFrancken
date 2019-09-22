<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDeductionNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $theme = 'francken';

    /**
     * @var int
     */
    private $deduction_member_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $deduction_member_id)
    {
        $this->deduction_member_id = $deduction_member_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /** @var DeductionEmailToMember */
        $member = DeductionEmailToMember::findOrFail($this->deduction_member_id);
        $date = $member->deduction->deducted_at;

        // $date = $member->deduction->
        return $this->subject("Incasso " . $date->format('Y-m-d'))
            ->from('treasurer@professorfrancken.nl', "Treasurer of T.F.V. 'Professor Francken'")
            ->markdown('admin.treasurer.deductions.mails.deduction')->with([
                'subject' => 'Deduction',

                'name' => $member->member->fullname,
                'description' => $member->description,
                'date' => $date->format('Y-m-d'),
                'deduction_amount' => $member->amount,
                // 'subject' => 'Incasso ' . $date,
            ]);
    }
}
