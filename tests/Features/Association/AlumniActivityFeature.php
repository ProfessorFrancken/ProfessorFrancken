<?php

declare(strict_types=1);

namespace Francken\Features\Association;

use Francken\Association\AlumniActivity\Alumnus;
use Francken\Association\AlumniActivity\Http\AdminAlumniActivityController;
use Francken\Association\AlumniActivity\Http\AlumniActivityController;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AlumniActivityFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function it_shows_participants_to_the_alumni_activity() : void
    {
        $alumnus = factory(Alumnus::class)->create();

        $this->visit(action([AdminAlumniActivityController::class, 'index']))
            ->assertResponseOk()
            ->see($alumnus->fullname);
    }

    /** @test */
    public function it_shows_all_members_joining_the_activity() : void
    {
        $alumnus = factory(Alumnus::class)->times(33)->create();

        $this->visit(action([AlumniActivityController::class, 'index']))
            ->assertResponseOk();

        collect($alumnus)->each(fn ($alumnus) => $this->see($alumnus->fullname));
    }

    /** @test */
    public function it_adds_alumnus() : void
    {
        $this->visit(action([AdminAlumniActivityController::class, 'index']))
             ->click('Add alumnus')
             ->type('John Snow', 'fullname')
             ->type("Night's watch", 'study')
             ->type('2020', 'graduation_year')
             ->press('Sign up')
             ->assertResponseOk()
             ->see('John Snow')
             ->see("Night's watch")
             ->see(2020);
    }

    /** @test */
    public function it_edits_alumnus() : void
    {
        $alumnus = factory(Alumnus::class)->create([
            'study' => "Night's watch"
        ]);

        $this->visit(action([AdminAlumniActivityController::class, 'edit'], ['alumnus' => $alumnus]))
             ->type('John Snow', 'fullname')
             ->type('King', 'study')
             ->type('2020', 'graduation_year')
             ->press('Save')
             ->assertResponseOk()
             ->see('John Snow')
             ->see('King')
             ->see(2020);

        $this->visit(action([AdminAlumniActivityController::class, 'edit'], ['alumnus' => $alumnus]))
            ->press('here')
            ->assertResponseOk();
    }
}
