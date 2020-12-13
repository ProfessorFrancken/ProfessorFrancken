<?php

declare(strict_types=1);

namespace Francken\Features\Admin;

use Faker\Factory;
use Francken\Association\News\Http\AdminNewsController;
use Francken\Association\News\News;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Shared\Http\Controllers\Admin\PagesController;
use Francken\Shared\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomPagesFeature extends TestCase
{
    use LoggedInAsAdmin;
    use DatabaseTransactions;

    /** @test */
    public function a_list_of_pages_is_shown() : void
    {
        $this->visit(action([PagesController::class, 'index']));

        $this->assertResponseOk();
    }

    /** @test */
    public function a_page_can_be_changed() : void
    {
        $page = factory(Page::class)->create();
        $this->visit(
            action([PagesController::class, 'show'], ['page' => $page])
        )
            ->see($page->title)
            ->assertResponseOk()
            ->click('Edit');


        $this->type('Covid-19', 'title')
            ->type('Corona', 'description')
            ->type('# Corona', 'source_content')
            ->press('Save')
            ->see('Covid-19')
            ->see('Corona');
    }
}
