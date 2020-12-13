<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Shared\Page;

class CustomPagesFeature extends TestCase
{
    /** @test */
    public function it_shows_a_page() : void
    {
        $page = factory(Page::class)->create(['is_published' => true]);
        $this->call('GET', $page->slug);

        $this->assertResponseOk();
        $this->see($page->compiled_content);
        $this->see($page->title);
    }

    public function it_shows_a_404_response_if_the_page_could_not_be_found() : void
    {
        $page = factory(Page::class)->create(['is_published' => false]);
        $this->call('GET', $page->slug);

        $this->assertResponseStatus(404);
    }
}
