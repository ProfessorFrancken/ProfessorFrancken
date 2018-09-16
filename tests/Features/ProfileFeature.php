<?php

declare(strict_types=1);

namespace Francken\Features;

use Auth;
use DB;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * The following are test that check that basic features of the admin page are working
 */
class ProfileFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    function it_shows_personal_information_of_a_member()
    {
        $this->visit('/profile')
            ->see('Mark Redeman');
    }

    /** @test */
    function it_shows_expenses_of_a_member()
    {
        $now = new \DateTimeImmutable;
        $ids = \DB::connection('francken-legacy')->table('transacties')
            ->insert([
                "lid_id" => 1403,
                "product_id" => 1,
                "aantal" =>	1,
                "prijs" => 100,
                "totaalprijs" => 100,
                "tijd" => $now
            ]);

        $this->visit('/profile/expenses')
            ->see('show transactions');

        // Cleanup
        \DB::connection('francken-legacy')->table('transacties')
            ->where('lid_id', 1403)
            ->where('tijd', $now)
            ->delete();
    }

    /** @test */
    public function it_shows_expenses_of_a_certain_month()
    {
        $now = new \DateTimeImmutable;
        \DB::connection('francken-legacy')->table('transacties')
            ->whereYear('tijd', $now->format('Y'))
            ->whereMonth('tijd', $now->format('m'))
            ->delete();

        \DB::connection('francken-legacy')->table('transacties')
            ->insert([
                "lid_id" => 1403,
                "product_id" => 1,
                "aantal" =>	10,
                "prijs" => 1000,
                "totaalprijs" => 10000,
                "tijd" => $now
            ]);

        $this->visit('/profile/expenses/' . $now->format('Y') . '/' . $now->format('m'))
            ->see('€10000');

        // Cleanup
        \DB::connection('francken-legacy')->table('transacties')
            ->where('lid_id', 1403)
            ->where('tijd', $now)
            ->delete();
    }
}
