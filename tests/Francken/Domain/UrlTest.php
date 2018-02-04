<?php

declare(strict_types=1);

namespace Francken\Tests\Domain;

use PHPUnit\Framework\TestCase as TestCase;
use Francken\Domain\Url;

class UrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     * @test
     */
    function it_is_constructed_from_a_string_representing_a_url(string $url, bool $throws = false)
    {
        if ($throws) {
            $this->expectException(\InvalidArgumentException::class);
        }

        $this->assertEquals($url, (string)(new Url($url)));
    }

    public function urlProvider()
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
