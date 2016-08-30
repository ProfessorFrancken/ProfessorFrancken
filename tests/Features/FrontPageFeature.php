<?php

declare(strict_types=1);

namespace Tests\Features;

use Tests\TestCase;

class FrontPageFeature extends TestCase
{
    /**
     * Checks if we can open the front page
     *
     * @test
     */
    public function the_front_page_shows_our_name()
    {
        $this->visit('/')
             ->see("T.F.V. 'Professor Francken'");
    }
}
