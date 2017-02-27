<?php

declare(strict_types=1);

namespace Francken\Tests\Activities;

use Francken\Domain\Activities\Location;
use Francken\Tests\SetupReconstitution;

class LocationTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    public function an_location_can_be_unspecified()
    {
        $this->assertInstanceOf(Location::class, Location::unspecified());
    }

    /** @test */
    public function a_specified_location_is_given_by_a_name_and_its_address()
    {
        $location = Location::fromNameAndAddress(
            'Francken Kamer',
            '9742GS',
            'Nijenborgh',
            '4'
        );

        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals('Francken Kamer', $location->name());
        $this->assertEquals('9742GS', $location->postalCode());
        $this->assertEquals('Nijenborgh', $location->streetName());
        $this->assertEquals('4', $location->streetNumber());
    }

    /** @test */
    public function a_location_can_be_serialized_and_deserialized()
    {
        $location = Location::fromNameAndAddress(
            'Francken Kamer',
            '9742GS',
            'Nijenborgh',
            '4'
        );

        $this->assertEquals(
            $location,
            Location::deserialize($location->serialize())
        );
    }
}
