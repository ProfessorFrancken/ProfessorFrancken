<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use DateInterval;
use DateTimeImmutable;
use Francken\Association\Boards\BoardMember;
use Francken\Shared\Clock\Clock;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class BirthdaysController
{
    public function index(Clock $clock) : View
    {
        $today = $clock->now()->sub(new DateInterval('P1D'));

        $members = BoardMember::with(['member'])
            ->get()
            ->filter(
                fn (BoardMember $member) : bool =>
                $member->member !== null && $member->member->geboortedatum !== null
            )
            ->map(function (BoardMember $member) : array {
                Assert::notNull($member->member);
                Assert::notNull($member->member->geboortedatum);

                return [
                    'name' => $member->member->fullname,
                    'birthday' => new DateTimeImmutable($member->member->geboortedatum)
                ];
            })
            ->map(function (array $member) use ($today) : array {
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
            })
            ->sortBy(fn ($member) => $member['day']->getTimestamp() - $today->getTimestamp())
            ->groupBy(fn ($member) => $member['day']->format('Y'))
            ->map(fn ($year) => $year->groupBy(fn ($member) => $member['day']->format('F')));

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
