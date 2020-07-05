<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use DateInterval;
use DateTimeImmutable;
use Francken\Association\Boards\BoardMember;
use Francken\Shared\Clock\Clock;

final class BirthdaysController
{
    public function index(Clock $clock)
    {
        $today = $clock->now()->sub(new DateInterval('P1D'));

        $members = BoardMember::with(['member'])->get()->filter(function (BoardMember $member) : bool {
            return $member->member !== null && $member->member->geboortedatum !== null;
        })->map(function (BoardMember $member): array {
            return [
                'name' => $member->member->full_name,
                'birthday' => new DateTimeImmutable($member->member->geboortedatum)
            ];
        })->map(function ($member) use ($today): array {
            $birthdayInSameYearAsNow = $member['birthday']->setDate(
                (int) $today->format('Y'),
                (int) $member['birthday']->format('m'),
                (int) $member['birthday']->format('d')
            );

            $birthday = $birthdayInSameYearAsNow->setDate(
                (int) $birthdayInSameYearAsNow->format('Y') + ($today > $birthdayInSameYearAsNow ? 1 : 0),
                (int) $birthdayInSameYearAsNow->format('m'),
                (int) $birthdayInSameYearAsNow->format('d')
            );

            return array_merge($member, ['day' => $birthday]);
        })->sortBy(function ($member) use ($today) {
            return ($member['day']->getTimestamp() - $today->getTimestamp());
        })->groupBy(function ($member) {
            return $member['day']->format('Y');
        })->map(function ($year) {
            return $year->groupBy(function ($member) {
                return $member['day']->format('F');
            });
        });

        return view('association.boards.birthdays', [
            'years' => $members, 'today' => new DateTimeImmutable(),
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => action([BoardsController::class, 'index']), 'text' => 'Boards'],
                ['url' => action([static::class, 'index']), 'text' => 'Birthdays'],
            ],
        ]);
    }
}
