<?php

declare(strict_types=1);

namespace Francken\Features;

class NewsFeature extends TestCase
{
    /** @test */
    function the_latest_news_is_shown()
    {
        $this->visit('/association/news')
            ->click('Read more')

            // Check that we now are on a news item page
            // which contains info about its author
            ->see('Written by');

        $this->assertResponseOk();
    }

    /** @test */
    function the_archive_can_be_used_to_search_for_old_news()
    {
        $this->visit('/association/news/archive');

        $this->assertResponseOk();
    }
}
