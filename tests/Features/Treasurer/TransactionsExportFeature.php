<?php

declare(strict_types=1);

namespace Francken\Features\Treasurer;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Treasurer\Deduction;
use Francken\Treasurer\Http\Controllers\AdminTransactionsController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionsExportFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function it_shows_previous_exports() : void
    {
        Deduction::truncate();
        $deductions = factory(Deduction::class, 5)->create();

        $this->visit(action([AdminTransactionsController::class, 'index']))
            ->assertResponseOk()
            ->click('Export transactions')
            ->assertResponseOk();

        $this->seeElementCount('tr[aria-label="Deduction"]', $deductions->count());

        $this->type('2025-03-03 10:33:00', 'until')
            ->press('Create')
            ->see('2025-03-03 10:33:00')
            ->see('Transactions / Export');
    }
}
