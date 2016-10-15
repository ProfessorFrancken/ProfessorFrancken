<?php

declare(strict_types=1);

namespace Francken\Features;

class StaticPagesFeature extends TestCase
{
    /** @test */
    function it_shows_a_404_response_if_the_page_could_not_be_found()
    {
        $response = $this->call('GET', '/this-url-should-not-exist');

        $this->assertEquals(404, $response->status());
    }


    /** @test */
    function it_wont_show_partial_views()
    {
        $response = $this->call('GET', '/about/_board');

        $this->assertEquals(404, $response->status());
    }
}
