<?php

declare(strict_types=1);

namespace Francken\Features\Association\Committees;

use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\Committees\Http\AdminCommitteesController;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

class AdminCommitteesFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    private Board $board;

    protected function setUp() : void
    {
        parent::setUp();
        $this->board = Board::create([
            'name' => 'Hè Watt?',
            'installed_at' => '2017-06-06',
            'board_year_slug' => '2017-2018',
            'photo_position' => '',
        ]);
    }

    /** @test */
    public function a_list_of_committees_is_shown() : void
    {
        $this->visit(action([AdminCommitteesController::class, 'index'], ['board' => $this->board]));

        $this->assertResponseOk();
    }

    /** @test */
    public function a_committee_can_be_started() : void
    {
        $this->withoutExceptionHandling();

        $this->visit(action([AdminCommitteesController::class, 'index'], ['board' => $this->board]))
             ->click('Start a committee')
             ->see('Start a new committee')
             ->type('S[ck]rip(t|t?c)ie', 'name')
             ->select('Digital anarchy', 'goal')
             ->type('kathinka@scriptcie.nl', 'email')
             ->check('is_public')
             ->attach(UploadedFile::fake()->image('scriptcie.png'), 'logo')
             ->attach(UploadedFile::fake()->image('scriptcie-photo.png'), 'photo')
             ->type('# Hoi', 'source_content')
             ->press('Start committee');

        $committee = Committee::where('name', 'S[ck]rip(t|t?c)ie')->firstOrFail();
        $previous_logo_id = $committee->logo_media_id;

        $this->assertEquals('S[ck]rip(t|t?c)ie', $committee->name);
        $this->assertEquals('sckripttcie', $committee->slug);

        // Contact details can be addded
        $this->assertEquals('kathinka@scriptcie.nl', $committee->email);

        $this->seePageIs(action(
            [AdminCommitteesController::class, 'show'],
            ['committee' => $committee, 'board' => $this->board]
        ))
            ->click('Edit')
            ->seePageIs(action(
                [AdminCommitteesController::class, 'edit'],
                ['committee' => $committee, 'board' => $this->board]
            ))
            ->type('Scriptcie', 'name')
            ->press('Save')
             ->seePageIs(action(
                [AdminCommitteesController::class, 'show'],
                ['committee' => $committee, 'board' => $this->board]
            ))
            ->see('Scriptcie');

        $committee->refresh();

        $this->assertEquals($previous_logo_id, $committee->logo_media_id);
        $this
            ->see('Suggested committee members')
            ->see('Members')
            ->see('Install committee member');
    }

    /** @test */
    public function a_committee_member_can_be_installed() : void
    {
        $committee = Committee::create([
            'board_id' => $this->board->id,
            'name' => 'S[ck]rip(t|t?c)ie',
            'goal' => 'Digital anarchy',
            'slug' => 'scriptcie',
            'is_public' => true,
        ]);
        $this->visit(action(
            [AdminCommitteesController::class, 'show'],
            ['committee' => $committee, 'board' => $this->board]
        ));
    }

    /** @test */
    public function continueing_a_committee_from_a_previous_board() : void
    {
        $statisch = Board::create([
            'name' => 'Statisch',
            'installed_at' => '2017-06-06',
            'board_year_slug' => '2017-2018',
            'photo_position' => '',
        ]);
        $committee = Committee::create([
            'board_id' => $this->board->id,
            'name' => 'S[ck]rip(t|t?c)ie',
            'goal' => 'Digital anarchy',
            'slug' => 'scriptcie',
            'is_public' => true,
        ]);
        $committee->members()->save(
            new CommitteeMember([
                'member_id' => 1403,
                'function' => 'Hoi',
                'installed_at' => new DateTimeImmutable('2016-06-06'),
            ])
        );

        $this->visit(
            action([AdminCommitteesController::class, 'index'], ['board' => $statisch])
        )->see('S[ck]rip(t|t?c)ie')
             ->within('#continuable-committees', function () : void {
                 $this->see('S[ck]rip(t|t?c)ie');
                 $this->press('Restart committee');
             });

        $committee = Committee::where('name', 'S[ck]rip(t|t?c)ie')
                   ->where('board_id', $statisch->id)
                   ->firstOrFail();

        $this->seePageIs(
            action([AdminCommitteesController::class, 'show'], ['board' => $statisch, 'committee' => $committee])
        );

        // TODO : check that we can continue the committe, then check that we can suggest committee members
    }
}
