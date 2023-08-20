<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;

class CommmitteesFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function committees_are_listed() : void
    {
        $board = Board::create([
            'name' => 'Hè Watt?',
            'installed_at' => '2017-06-06',
            'board_year_slug' => '2017-2018',
            'photo_position' => '',
        ]);
        Committee::create([
            'board_id' => $board->id,
            'name' => 'S[ck]rip(t|t?c)ie',
            'slug' => 'scriptcie',
            'is_public' => true,
        ]);

        $this->visit('/association/committees')
             ->see('Committees')
             ->see('S[ck]rip(t|t?c)ie');

        $this->assertResponseOk();
    }

    /** @test */
    public function more_info_about_a_committee_can_be_shown() : void
    {
        $board = Board::create([
            'name' => 'Hè Watt?',
            'installed_at' => '2017-06-06',
            'board_year_slug' => '2017-2018',
            'photo_position' => '',
        ]);
        Committee::create([
            'board_id' => $board->id,
            'name' => 'S[ck]rip(t|t?c)ie',
            'slug' => 'scriptcie',
            'is_public' => true,
        ]);

        $this->visit('/association/2017-2018/committees')
            ->click('S[ck]rip(t|t?c)ie')
             ->seePageIs('/association/2017-2018/committees/scriptcie')
            ->see('Committee members');
    }
}
