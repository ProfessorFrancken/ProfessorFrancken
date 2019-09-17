<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

final class SponsorsController
{
    public function index()
    {
        return collect(['sponsors' => [
            [
                'name' => 'Thales',
                'image' => $this->image('/images/companies/plus-one/thales.png'),
            ],
            [
                'name' => 'Demcon',
                'image' => $this->image('/images/companies/plus-one/demcon.png'),
            ],
            [
                'name' => 'ASML',
                'image' => $this->image('/images/companies/plus-one/asml.png'),
            ],
        ]]);
    }

    private function image(string $url) : string
    {
        return image($url);
    }
}
