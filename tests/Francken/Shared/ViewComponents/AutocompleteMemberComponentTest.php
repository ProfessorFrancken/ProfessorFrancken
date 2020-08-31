<?php

declare(strict_types=1);

namespace Francken\Tests\Shared\ViewComponents;

use Francken\Features\TestCase;
use Francken\Shared\ViewComponents\AutocompleteMemberComponent;

class AutocompleteMemberComponentTest extends TestCase
{
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
