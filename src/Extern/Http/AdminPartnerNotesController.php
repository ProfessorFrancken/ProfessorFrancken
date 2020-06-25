<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\Note;
use Francken\Extern\Partner;
use Illuminate\Http\Request;

final class AdminPartnerNotesController
{
    public function store(Request $request, Partner $partner)
    {
        $memberId = $request->user()->member_id;

        $partner->notes()->save(
            new Note([
                'note' => $request->input('note'),
                'member_id' => $memberId
            ])
        );

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }
}
