<?php

declare(strict_types=1);

namespace Francken\Association\Members\Notifications;

use Francken\Association\Members\Events\MemberPhoneNumberWasChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotifyBoardAboutPhoneNumberChange extends Notification
{
    use Queueable;

    private MemberPhoneNumberWasChanged $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MemberPhoneNumberWasChanged $event)
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
        $from = $this->event->oldPhoneNumber();
        $to = $this->event->phoneNumber();
        return [
            'member_id' => $member->id,
            'headline' => sprintf('%s changed their phone number', $member->fullname),
            'from' => $from,
            'to' => $to,
            'text' => sprintf('From %s to %s', $from, $to),
        ];
    }
}
