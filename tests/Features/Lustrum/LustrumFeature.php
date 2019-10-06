<?php


declare(strict_types=1);

namespace Francken\Features\Lustrum;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Lustrum\Http\Controllers\LustrumController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LustrumFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function a_list_of_deductions_are_shown() : void
    {
        $this->visit(action([LustrumController::class, 'index']));

        $this->assertResponseOk();
    }
}


