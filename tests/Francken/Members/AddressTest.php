<?php

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function an_address_consists_of_a_city_a_postal_code_and_street_naeme_with_a_street_number()
    {
        $address = new Address(
            'Groningen',
            '9742GS',
            'Plutolaan 11'
        );

        $this->assertEquals('Groningen', $address->city());
        $this->assertEquals('9742GS', $address->postalCode());
        $this->assertEquals('Plutolaan 11', $address->address());
    }

}
