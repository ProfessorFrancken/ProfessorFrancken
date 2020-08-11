<?php

declare(strict_types=1);

namespace Francken\Tests\Shared\ViewComponents;

use Francken\Shared\ViewComponents\AutocompleteMemberComponent;
use Francken\Tests\LaravelTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AutocompleteMemberComponentTest extends LaravelTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_shows_company_logos_in_our_footer() : void
    {
        $component = new AutocompleteMemberComponent();
        $data = $component->data();
        $this->assertEquals('member', $data['name']);
        $this->assertEquals('member_id', $data['nameId']);
        $this->assertNull($data['value']);
        $this->assertNull($data['valueId']);
        $this->assertEquals('Member', $data['placeholder']);
        $this->assertEquals('Member', $data['label']);

        $view = $component->render();
        $this->assertEquals('components.forms.autocomplete-member', $view->getName());
    }
}
