<?php

declare(strict_types=1);

namespace Francken\Tests\Domain;

use InvalidArgumentException;
use Francken\Shared\Url;
use PHPUnit\Framework\TestCase as TestCase;

class UrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     * @test
     */
    public function it_is_constructed_from_a_string_representing_a_url(string $url, bool $throws = false) : void
    {
        if ($throws) {
            $this->expectException(InvalidArgumentException::class);
        }

        $this->assertEquals($url, (string)(new Url($url)));
    }

    public function urlProvider(): array
    {
        return [
            ['http://test.com'],
            ['https://test.com'],
            ['http://www.test.com'],
            ['http://www.test.com/test'],
            ['test.com', true],
        ];
    }
}
