<?php

declare(strict_types=1);

namespace Francken\Features\Treasurer;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Treasurer\Http\Controllers\DeductionsController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

class EmailDeductionsFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    private $news;

    /** @test */
    public function a_list_of_deductions_are_shown() : void
    {
        $this->visit(action([DeductionsController::class, 'index']));

        $this->assertResponseOk();
    }

    /** @test */
    public function a_new_deduction_can_be_uploaded() : void
    {
        $this->visit(action([DeductionsController::class, 'create']))
            ->see('Start');

        $this->assertResponseOk();
        $this->type('2019-07-24', 'deducted_at')
            ->type('2019-06-01', 'deduction_from')
            ->type('2019-07-01', 'deduction_to')
            ->attach(
                new UploadedFile(__DIR__ . '/deduction.csv', 'deduction.csv'),
                'deduction'
            )
            ->press('Upload');
    }
}
