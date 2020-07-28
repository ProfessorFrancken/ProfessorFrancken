<?php

declare(strict_types=1);

namespace Francken\Association\Members\Notifications;

use Francken\Association\Members\Events\MemberPaymentDetailsWereChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotifyBoardAboutPaymentDetailsChange extends Notification
{
    use Queueable;

    private MemberPaymentDetailsWereChanged $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MemberPaymentDetailsWereChanged $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via() : array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray() : array
    {
        $member = $this->event->member();
        $from = sprintf("%s (%s)", $this->event->oldIban(), $this->event->oldConsumptionCounter());
        $to = sprintf("%s (%s)", $this->event->iban(), $this->event->consumptionCounter());
        return [
            'member_id' => $member->id,
            'headline' => sprintf('%s changed their payment details', $member->fullname),
            'from' => $from,
            'to' => $to,
            'text' => sprintf('From %s to %s', $from, $to),
        ];
    }
}
