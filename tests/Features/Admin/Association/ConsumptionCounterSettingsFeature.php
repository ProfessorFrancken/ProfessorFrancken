<?php

declare(strict_types=1);

namespace Francken\Features\Admin\Association;

use Francken\Association\Boards\Board;
use Francken\Association\LegacyMember;
use Francken\Association\Members\Http\Controllers\Admin\ConsumptionCounterSettingsController;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Treasurer\MemberExtra;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

class ConsumptionCounterSettingsFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_member() : void
    {
        factory(Board::class)->create();
        $member = factory(LegacyMember::class)->create();

        $this->visit(action([ConsumptionCounterSettingsController::class, 'edit'], ['member' => $member]))
             ->type(33, 'prominent')
             ->type('#aabbcc', 'kleur')
             ->type('Hoi', 'bijnaam')
             ->check('small_button')
             ->attach(UploadedFile::fake()->image('image.png'), 'image')
            ->press('Save');

        $settings = MemberExtra::ofMember($member->id)->first();
        $this->assertEquals('33', $settings->prominent);
        $this->assertEquals('#aabbcc', $settings->kleur);
        $this->assertEquals('Hoi', $settings->bijnaam);
        $this->assertTrue($settings->has_small_button);
    }
}
