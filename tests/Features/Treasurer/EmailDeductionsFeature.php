<?php

declare(strict_types=1);

namespace Francken\Features\Treasurer;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Treasurer\DeductionEmail;
use Francken\Treasurer\Http\Controllers\DeductionsController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class EmailDeductionsFeature extends TestCase
{
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
        $this->assertResponseOk();

        $deductionEmail = DeductionEmail::whereDate('deducted_at', '2019-07-24')->first();

        $this->assertNotNull($deductionEmail);
        $toMembers = $deductionEmail->deductionToMembers;
        $this->assertCount(2, $toMembers);

        $this->assertEquals(1403, $toMembers[0]->member_id);
        $this->assertEquals("Food and drinks until June 18, Being board", $toMembers[0]->description);
        $this->assertEquals(3333, $toMembers[0]->amount_in_cents);
        $this->assertEquals(3140, $toMembers[1]->amount_in_cents);
    }

    /** @test */
    public function a_validation_message_is_shown() : void
    {
        $this->visit(action([DeductionsController::class, 'create']))
            ->see('Start');

        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $this->assertResponseOk();
        $this->type('2019-07-24', 'deducted_at')
            ->type('2019-06-01', 'deduction_from')
            ->type('2019-07-01', 'deduction_to')
            ->attach(
                new UploadedFile(__DIR__ . '/deduction-2.csv', 'deduction-2.csv'),
                'deduction'
            )
            ->press('Upload');
    }
}
