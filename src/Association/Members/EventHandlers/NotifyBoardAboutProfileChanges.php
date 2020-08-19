<?php

declare(strict_types=1);

namespace Francken\Association\Members\EventHandlers;

use Francken\Association\Boards\Board;
use Francken\Association\Members\Events\MemberAddressWasChanged;
use Francken\Association\Members\Events\MemberEmailWasChanged;
use Francken\Association\Members\Events\MemberPaymentDetailsWereChanged;
use Francken\Association\Members\Events\MemberPhoneNumberWasChanged;
use Francken\Association\Members\Notifications\NotifyBoardAboutAddressChange;
use Francken\Association\Members\Notifications\NotifyBoardAboutEmailChange;
use Francken\Association\Members\Notifications\NotifyBoardAboutPaymentDetailsChange;
use Francken\Association\Members\Notifications\NotifyBoardAboutPhoneNumberChange;
use Francken\Shared\EventHandler;

final class NotifyBoardAboutProfileChanges extends EventHandler
{
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

    public function whenMemberPaymentDetailsWereChanged(MemberPaymentDetailsWereChanged $event) : void
    {
        $currentBoard = Board::current()->firstOrFail();
        $currentBoard->notify(
            new NotifyBoardAboutPaymentDetailsChange($event)
        );
    }
}
