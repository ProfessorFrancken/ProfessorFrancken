<?php

declare(strict_types=1);

namespace Francken\Association\Members\EventHandlers;

use Francken\Association\Boards\Board;
use Francken\Association\Members\Events\MemberAddressWasChanged;
use Francken\Association\Members\Events\MemberEmailWasChanged;
use Francken\Association\Members\Events\MemberPhoneNumberWasChanged;
use Francken\Association\Members\Notifications\NotifyBoardAboutAddressChange;
use Francken\Association\Members\Notifications\NotifyBoardAboutEmailChange;
use Francken\Association\Members\Notifications\NotifyBoardAboutPhoneNumberChange;
use Illuminate\Contracts\Queue\ShouldQueue;

final class NotifyBoardAboutProfileChanges //implements ShouldQueue
{
    public function handle(object $event) : void
    {
        $method = $this->getHandleMethod($event);

        if ( ! method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    public function whenMemberEmailWasChanged(MemberEmailWasChanged $event) : void
    {
        $currentBoard = Board::current()->firstOrFail();
        $currentBoard->notify(
            new NotifyBoardAboutEmailChange($event)
        );
    }

    public function whenMemberAddressWasChanged(MemberAddressWasChanged $event) : void
    {
        $currentBoard = Board::current()->firstOrFail();
        $currentBoard->notify(
            new NotifyBoardAboutAddressChange($event)
        );
    }

    public function whenMemberPhoneNumberWasChanged(MemberPhoneNumberWasChanged $event) : void
    {
        $currentBoard = Board::current()->firstOrFail();
        $currentBoard->notify(
            new NotifyBoardAboutPhoneNumberChange($event)
        );
    }

    private function getHandleMethod(object $event) : string
    {
        $classParts = explode('\\', get_class($event));

        return 'when' . end($classParts);
    }
}
