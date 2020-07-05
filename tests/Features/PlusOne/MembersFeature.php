<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Features\TestCase;

class MembersFeature extends TestCase
{
    /** @test */
    public function it_returns_members_wanting_to_be_on_the_plus_one_system() : void
    {
        $this->json('POST', '/api/plus-one/authenticate', [
            'password' => 'hoi',
        ]);
        $token = $this->response->decodeResponseJson()['token'];

        $this->json('GET', '/api/plus-one/members', [], ['Authorization' => 'Bearer ' . $token])
             ->seeJsonStructure([
                 'members' => [[
                     "id",
                     "voornaam",
                     "initialen",
                     "tussenvoegsel",
                     "achternaam",
                     "geboortedatum",
                     "prominent",
                     "kleur",
                     "afbeelding",
                     "bijnaam",
                     "button_width",
                     "button_height",
                     "latest_purchase_at",
                 ]]
             ]);

        $this->assertResponseStatus(200);
    }
}
