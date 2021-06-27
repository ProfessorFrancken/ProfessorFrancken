<?php

declare(strict_types=1);

namespace Francken\Features\Treasurer;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Treasurer\Http\Controllers\AdminProductExtrasController;
use Francken\Treasurer\Http\Controllers\AdminProductsController;
use Francken\Treasurer\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

class ProductsFeature extends TestCase
{
    use DatabaseTransactions;
    use LoggedInAsAdmin;

    /** @test */
    public function a_list_of_products_are_shown() : void
    {
        // Make sure that the next products are shown on the first page,
        // Save since we're doing this in a transaction, but not nice..
        Product::all()->each->delete();

        $beerProduct = factory(Product::class)->create(['categorie' => 'Bier', 'beschikbaar' => true]);
        $foodProduct = factory(Product::class)->create(['categorie' => 'Eten', 'beschikbaar' => true]);
        $sodaProduct = factory(Product::class)->create(['categorie' => 'Fris', 'beschikbaar' => true]);

        $this->visit(action([AdminProductsController::class, 'index']))
             ->see($beerProduct->name)
             ->see($foodProduct->name)
             ->see($sodaProduct->name);
        $this->visit(action([AdminProductsController::class, 'index'], ['category' => 'beer']))
             ->see($beerProduct->name)
             ->dontSee($foodProduct->name)
             ->dontSee($sodaProduct->name);
        $this->visit(action([AdminProductsController::class, 'index'], ['category' => 'soda']))
             ->dontSee($beerProduct->name)
             ->dontSee($foodProduct->name)
             ->see($sodaProduct->name);
        $this->visit(action([AdminProductsController::class, 'index'], ['category' => 'food']))
             ->dontSee($beerProduct->name)
             ->see($foodProduct->name)
             ->dontSee($sodaProduct->name);

        $unavailableProduct = factory(Product::class)->create(['beschikbaar' => false]);
        $this->visit(action([AdminProductsController::class, 'index']))
             ->check('unavailable')
             ->type($unavailableProduct->name, 'name')
             ->press('Apply filters')
             ->see($unavailableProduct->name)
             ->dontSee($beerProduct->name)
             ->dontSee($foodProduct->name)
             ->dontSee($sodaProduct->name);


        $this->assertResponseOk();
    }

    /** @test */
    public function it_adds_a_new_product() : void
    {
        $this->visit(action([AdminProductsController::class, 'create']))
             ->type('Hertog Jan', 'name')
             ->type(133, 'price')
             ->select('Beer', 'category')
            ->check('available')
             ->type(1, 'position')
            ->attach(UploadedFile::fake()->image('hertog.png'), 'photo')
            ->press('Add');

        $product = Product::query()
            ->where('naam', 'Hertog Jan')
            ->orderBy('created_at', 'desc')
            ->first();

        $this->assertEquals(133, $product->price);

        $this->seePageIs(action(
            [AdminProductsController::class, 'show'],
            ['product' => $product]
        ))
             ->click('Edit')
             ->seePageIs(action(
                 [AdminProductsController::class, 'edit'],
                 ['product' => $product]
             ))
             ->type('Dors', 'name')
            ->type(33, 'price')
            ->attach(UploadedFile::fake()->image('hertog.png'), 'photo')
            ->press('Save')
            ->seePageIs(action(
                [AdminProductsController::class, 'show'],
                ['product' => $product]
            ));

        $product->refresh();
        $this->assertEquals("Dors", $product->name);
        $this->assertEquals(33, $product->price);
    }


    /** @test */
    public function it_adds_extras_to_a_product() : void
    {
        $product = factory(Product::class)->create();
        $this->visit(action([AdminProductExtrasController::class, 'create'], ['product' => $product]))
            ->type('#ff0000', 'color')
            ->attach(UploadedFile::fake()->image('hertog.png'), 'splash_photo')
            ->press('Add')
            ->seePageIs(action(
                [AdminProductsController::class, 'show'],
                ['product' => $product]
            ));


        $this->assertEquals('#ff0000', $product->extra->color);
        $this->assertNotNull($product->splash_url);

        $this->visit(action([AdminProductExtrasController::class, 'edit'], ['product' => $product]))
            ->type('#ffff00', 'color')
             ->press('Save')
            ->seePageIs(action(
                [AdminProductsController::class, 'show'],
                ['product' => $product]
            ));

        $product->extra->refresh();
        $this->assertEquals('#ffff00', $product->extra->color);
    }
}
