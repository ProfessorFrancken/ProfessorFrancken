<?php

declare(strict_types=1);

namespace Francken\Features\Treasurer;

use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Treasurer\Http\Controllers\AdminTransactionsController;
use Francken\Treasurer\Product;
use Francken\Treasurer\Transaction;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionsFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function it_shwos_transactions() : void
    {
        $product = factory(Product::class)->create();
        $transaction = factory(Transaction::class)->create([
            'product_id' => $product->id
        ]);


        $this->visit(action([AdminTransactionsController::class, 'index']))
            ->assertResponseOk()
            ->type($transaction->lid_id, 'member_id')
            ->select($product->id, 'product_id')
            ->select($transaction->tijd->format('Y-m-d'), 'from')
            ->select($transaction->tijd->format('Y-m-d'), 'until')
            ->press('Apply filters')
            ->see($transaction->purchasedBy->fullname);
    }

    /** @test */
    public function it_manages_transactions() : void
    {
        $product = factory(Product::class)->create();
        $member = factory(LegacyMember::class)->create();
        $time = new DateTimeImmutable();

        $this->visit(action([AdminTransactionsController::class, 'index']))
             ->click('Add a transaction')
            ->type($member->id, 'member_id')
            ->select($product->id, 'product_id')
            ->type($time->format('Y-m-d H:i:s'), 'time')
            ->press('Add');

        $latestTransaction = Transaction::orderBy('id', 'desc')->first();

        $this->assertEquals($member->id, $latestTransaction->lid_id);
        $this->assertEquals($product->id, $latestTransaction->product_id);
        $this->assertEquals($product->prijs, $latestTransaction->prijs);
        $this->assertEquals($product->prijs, $latestTransaction->totaalprijs);
        $this->assertEquals(1, $latestTransaction->aantal);
        $this->assertEquals($time->format('Y-m-d H:i:s'), $latestTransaction->tijd->format('Y-m-d H:i:s'));

        $this->visit(action([AdminTransactionsController::class, 'edit'], ['transaction' => $latestTransaction]))
            ->type(100, 'price')
            ->press('Save');

        $latestTransaction->refresh();
        $this->assertEquals(100, $latestTransaction->prijs);
        $this->assertEquals(100, $latestTransaction->totaalprijs);
    }

    /** @test */
    public function it_keeps_the_total_price() : void
    {
        $product = factory(Product::class)->create();
        $time = new DateTimeImmutable();
        $transaction = factory(Transaction::class)->create([
            'product_id' => $product->id,
            'prijs' => 100,
            'totaalprijs' => 200,
            'aantal' => 2,
        ]);

        $this->visit(action([AdminTransactionsController::class, 'edit'], ['transaction' => $transaction]))
            ->type($time->format('Y-m-d H:i:s'), 'time')
            ->press('Save');

        $transaction->refresh();
        $this->assertEquals(100, $transaction->prijs);
        $this->assertEquals(200, $transaction->totaalprijs);
        $this->assertEquals(2, $transaction->aantal);
    }


    /** @test */
    public function it_keeps_the_total_price2() : void
    {
        $product = factory(Product::class)->create();
        $time = new DateTimeImmutable();
        $transaction = factory(Transaction::class)->create([
            'product_id' => $product->id,
            'prijs' => 100,
            'totaalprijs' => 200,
            'aantal' => 2,
        ]);

        $this->visit(action([AdminTransactionsController::class, 'edit'], ['transaction' => $transaction]))
            ->type($time->format('Y-m-d H:i:s'), 'time')
            ->type(300, 'price')
            ->press('Save');

        $transaction->refresh();
        $this->assertEquals(300, $transaction->prijs);
        $this->assertEquals(200, $transaction->totaalprijs);
        $this->assertEquals(2, $transaction->aantal);
    }
}
