<?php

declare(strict_types=1);

namespace Francken\Association\Members\Notifications;

use Francken\Association\Members\Events\MemberAddressWasChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotifyBoardAboutAddressChange extends Notification
{
    use Queueable;

    private MemberAddressWasChanged $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MemberAddressWasChanged $event)
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

        $from = $this->event->oldAddress() !== null
              ? $this->event->oldAddress()->toString()
              : "Unkown address";
        $to = $this->event->address()->toString();

        return [
            'member_id' => $member->id,
            'headline' => sprintf('%s changed their address', $member->fullname),
            'from' => $from,
            'to' => $to,
            'text' => sprintf('From %s to %s', $from, $to),
        ];
    }
}
