<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\Symposium\Mail\NotifyCommittee;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;

class NotifySymposiumCommittee implements ShouldQueue
{
    private Mailer $mail;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    public function handle(
        ParticipantRegisteredForSymposium $event
    ) : void {
        $board = Board::current()->firstOrFail();
        $committee = $board->committees()->where('name', 'Sympcie')->firstOrFail();
        $committeeMembers = $committee->load('members.member')->members;
        $names = $committeeMembers
               ->filter(fn (CommitteeMember $m) => $m->member !== null)
               ->map(function (CommitteeMember $member) {
                   Assert::notNull($member->member);
                   return $member->member->fullname;
               })
               ->toArray();


        $whoNeedsToTakeAnAdt = Arr::random($names);

        // This is very important
        AdCount::create([
            'symposium_id' => $event->participant->symposium_id,
            'participant_id' => $event->participant->id,
            'name' => $whoNeedsToTakeAnAdt,
            'consumed' => false,
        ]);


        $this->mail->to('sympfr@gmail.com')
            ->send(new NotifyCommittee(
                $event->participant,
                $whoNeedsToTakeAnAdt
            ));
    }
}
