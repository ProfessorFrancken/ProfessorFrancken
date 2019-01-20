<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use DateTimeImmutable;

final class MembersController
{
    public function index()
    {
        return view('profile.members');
    }
}
