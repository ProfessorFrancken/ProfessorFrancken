<?php

declare(strict_types=1);

namespace Francken\Tests\Shared\ViewComponents;

use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\Footer;
use Francken\Shared\ViewComponents\FooterSponsorsComponent;
use Francken\Tests\LaravelTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FooterSponsorsComponentTest extends LaravelTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_company_logos_in_our_footer() : void
    {
        $partner = factory(Partner::class)->create();
        $footer = factory(Footer::class)->create([
            'partner_id' => $partner->id,
            'is_enabled' => true,
        ]);

        $component = new FooterSponsorsComponent();
        $data = $component->data();
        $this->assertEquals(
            [
                [
                    'name' => $partner->name,
                    'footer-link' => $footer->referral_url,
                    'footer-logo' => $footer->logo,
                ]
            ],
            $data['footer']
        );

        $view = $component->render();
        $this->assertEquals('layout._sponsors', $view->getName());
    }
}
