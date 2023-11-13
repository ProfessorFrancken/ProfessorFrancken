<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\LegacyMember;
use Francken\Features\TestCase;
use Francken\PlusOne\Http\CommitteesStatisticsController;
use Francken\PlusOne\JwtToken;
use Francken\Treasurer\Product;
use Francken\Treasurer\Transaction;

class CommitteesStatisticsFeature extends TestCase
{
    /** @test */
    public function it_returns_statistics_per_committee() : void
    {
        [$compucieMembers, $scriptcieMembers, $borrelcieMembers] = $this->setupData(2017);

        $members = collect([
            ...$compucieMembers,
            ...$scriptcieMembers,
            ...$borrelcieMembers
        ])->unique();

        $members->map(function ($member) {
            return factory(Transaction::class, 10)->create([
                'tijd' => '2017-07-01 12:00:00',
                'lid_id' => $member->id
            ]);
        });

        $token = new JwtToken(config('francken.plus_one.key'));
        $this->json(
            'GET',
            action([CommitteesStatisticsController::class, 'index']),
            [
                'startDate' => '2017-07-01',
                'endDate' => '2017-08-01',
            ],
            ['Authorization' => 'Bearer ' . $token->token()->toString()]
        );

        $this
            ->assertResponseStatus(200)
            ->seeJsonStructure([
                'statistics' => [[
                    'committee' => [
                        'id',
                        'name'
                    ],
                    'beer',
                    'soda',
                    'food',
                ]]
            ]);
    }

    /** @test */
    public function it_returns_statistics_per_committee_for_a_day() : void
    {
        [$compucieMembers, $scriptcieMembers, $borrelcieMembers] = $this->setupData(2017);

        $members = collect([
            ...$compucieMembers,
            ...$scriptcieMembers,
            ...$borrelcieMembers
        ])->unique();


        $beer = factory(Product::class)->create(['categorie' => 'Bier']);
        $soda = factory(Product::class)->create(['categorie' => 'Fris']);
        $food = factory(Product::class)->create(['categorie' => 'Eten']);
        $compucieMembers->map(function ($member) use($food) {
            return factory(Transaction::class, 10)->create([
                'tijd' => '2017-07-01 12:00:00',
                'lid_id' => $member->id,
                'product_id' => $food->id
            ]);
        });
        $scriptcieMembers->map(function ($member) use ($beer) {
            return factory(Transaction::class, 10)->create([
                'tijd' => '2017-07-01 12:00:00',
                'lid_id' => $member->id,
                'product_id' => $beer->id
            ]);
        });
        $borrelcieMembers->map(function ($member) use ($soda){
            return factory(Transaction::class, 10)->create([
                'tijd' => '2017-07-01 12:00:00',
                'lid_id' => $member->id,
                'product_id' => $soda->id
            ]);
        });

        $token = new JwtToken(config('francken.plus_one.key'));
        $this->json(
            'GET',
            action([CommitteesStatisticsController::class, 'index']),
            [
                'startDate' => '2017-07-01',
                'endDate' => '2017-07-01',
            ],
            ['Authorization' => 'Bearer ' . $token->token()->toString()]
        );

        $this
            ->assertResponseStatus(200)
            ->seeJsonStructure([
                'statistics' => [[
                    'committee' => [
                        'id',
                        'name'
                    ],
                    'beer',
                    'soda',
                    'food',
                ]]
            ]);

        $this->seeJsonEquals([
            'statistics' => [
                [
                    'committee' => ['id' => 1, 'name' => ''],
                    'beer' => 0,
                    'food' => 100,
                    'soda' => 10,
                ],[
                    'committee' => ['id' => 2, 'name' => ''],
                    'beer' => 100,
                    'food' => 0,
                    'soda' => 10,
                ],[
                    'committee' => ['id' => 3, 'name' => ''],
                    'beer' => 10,
                    'food' => 10,
                    'soda' => 100,
                ]
            ]
        ]);
    }

    private function setupData(int $boardYear) {
        $members = factory(LegacyMember::class, 33)->create();

        $endBoardYear = $boardYear + 1;
        $board = factory(Board::class)->create([
            'installed_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$boardYear}-06-06"),
            'demissioned_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$endBoardYear}-06-06"),
            'decharged_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$endBoardYear}-06-06"),
        ]);

        $compucie = factory(Committee::class)->create(['board_id' => $board->id, 'name' => 'Compucie']);
        $scriptcie = factory(Committee::class)->create(['board_id' => $board->id, 'name' => 'Scriptcie']);
        $borrelcie = factory(Committee::class)->create(['board_id' => $board->id, 'name' => 'Borrelcie']);

        $compucieMembers = $members->random(10);
        $scriptcieMembers = $members->reject(fn ($m) => $compucieMembers->contains($m))->random(10);
        $borrelcieMembers = $members->reject(fn ($m) => $compucieMembers->contains($m) || $scriptcieMembers->contains($m))->random(8);
        $borrelcieMembers->push($compucieMembers[0]);
        $borrelcieMembers->push($scriptcieMembers[0]);

        $compucieMembers->each(
            fn ($member) => factory(CommitteeMember::class)->create([
                'member_id' => $member->id,
                'committee_id' => $compucie->id,
                'installed_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$boardYear}-06-06"),
                'decharged_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$endBoardYear}-06-06"),
            ])
        );

        $scriptcieMembers->each(
            fn ($member) => factory(CommitteeMember::class)->create([
                'member_id' => $member->id,
                'committee_id' => $scriptcie->id,
                'installed_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$boardYear}-06-06"),
                'decharged_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$endBoardYear}-06-06"),
            ])
        );
        $borrelcieMembers->each(
            fn ($member) => factory(CommitteeMember::class)->create([
                'member_id' => $member->id,
                'committee_id' => $borrelcie->id,
                'installed_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$boardYear}-06-06"),
                'decharged_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$endBoardYear}-06-06"),
            ])
        );

        return [
            $compucieMembers, $scriptcieMembers, $borrelcieMembers
        ];
    }
}
