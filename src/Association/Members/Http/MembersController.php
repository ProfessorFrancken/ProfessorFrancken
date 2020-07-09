<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use Illuminate\View\View;

final class MembersController
{
    public function index() : View
    {
        return view('profile.members');
    }
}
