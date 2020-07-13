<?php

declare(strict_types=1);

namespace Francken\Association\Members\Notifications;

use Francken\Association\Members\Events\MemberEmailWasChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotifyBoardAboutEmailChange extends Notification
{
    use Queueable;

    private MemberEmailWasChanged $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MemberEmailWasChanged $event)
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
        $from = $this->event->oldEmail()->toString();
        $to = $this->event->email()->toString();

        return [
            'member_id' => $member->id,
            'headline' => sprintf('%s changed their email', $member->fullname),
            'from' => $from,
            'to' => $to,
            'text' => sprintf('From %s to %s', $from, $to),
        ];
    }
}
