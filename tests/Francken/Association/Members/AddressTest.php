<?php

declare(strict_types=1);

namespace Tests\Francken\Association\Members;

use Francken\Association\Members\Address;

class AddressTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function an_address_consists_of_a_city_a_postal_code_and_street_naeme_with_a_street_number() : void
    {
        $address = new Address(
            'Groningen',
            '9742GS',
            'Plutolaan 11',
            'Netherlands'
        );

        $this->assertEquals('Groningen', $address->city());
        $this->assertEquals('9742GS', $address->postalCode());
        $this->assertEquals('Plutolaan 11', $address->address());
        $this->assertEquals('Netherlands', $address->country());
    }
}
