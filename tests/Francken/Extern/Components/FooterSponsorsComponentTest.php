<?php

declare(strict_types=1);

namespace Francken\Tests\Extern;

use Francken\Extern\CompanyRepository;
use Francken\Extern\Components\FooterSponsorsComponent;
use Francken\Tests\LaravelTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FooterSponsorsComponentTest extends LaravelTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_company_logos_in_our_footer() : void
    {
        $companies = new CompanyRepository([
            [
                'name' => 'Zernike Institute for Advanced Materials',
                'summary' => '',
                'footer-link' => 'http://www.rug.nl/zernike/',
                'footer-logo' => '/images/footer/ziam.png',
                'show-in-footer' => true,
            ]
        ]);
        $component = new FooterSponsorsComponent($companies);

        $data = $component->data();
        $this->assertEquals(
            [
                [
                    'name' => 'Zernike Institute for Advanced Materials',
                    'footer-link' => 'http://www.rug.nl/zernike/',
                    'footer-logo' => '/images/footer/ziam.png',
                ]
            ],
            $data['footer']
        );

        $view = $component->render();
        $this->assertEquals('layout._sponsors', $view->getName());
    }
}
