<?php

declare(strict_types=1);

namespace Francken\Features\Shared;

use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Francken\Shared\Settings\Http\Controllers\SettingsController;
use Francken\Shared\Settings\Settings;
use Prophecy\PhpUnit\ProphecyTrait;

class SettingsFeature extends TestCase
{
    use LoggedInAsAdmin;
    use ProphecyTrait;

    /** @test */
    public function it_allows_us_to_set_settings() : void
    {
        $this->visit(action([SettingsController::class, 'index']));

        $settings = $this->prophesize(Settings::class);
        $this->app->instance(Settings::class, $settings->reveal());

        $this
             ->type('hoi', 'number_of_extern')
             ->type('hoi', 'number_of_chair')
             ->type('image', 'header_image')
            ->check('private_albums')
            ->check('navigation_show_login')
            ->check('navigation_show_slef')
            ->uncheck('navigation_show_symposium')
            ->uncheck('navigation_show_pienter')
            ->uncheck('navigation_show_expedition')
            ->uncheck('navigation_show_bbd')
            ->press('Save');

        $settings->updateSettings([
            "number_of_extern" => "hoi",
            "number_of_chair" => "hoi",
            "header_image" => "image",
            "private_albums" => true,
            "navigation_show_login" => true,
            "navigation_show_slef" => true,
            "navigation_show_symposium" => false,
            "navigation_show_pienter" => false,
            "navigation_show_expedition" => false,
            "navigation_show_bbd" => false,
        ])->shouldHaveBeenCalled();
    }
}
