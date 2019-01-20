<?php

declare(strict_types=1);

namespace Francken\Borrelcie\Http;

final class PersonalStatisticsController
{

    public function index()
    {
        // Autocomplete on all members who've given permission
    }

    public function show($memberId)
    {
        // Check if member has given permission

        return [
            'id' => 42,
            'display-name' => 'hoi',
            'beer' => 9000,
            'drinks' => 0,
            'food' => 0
        ];
    }
}
