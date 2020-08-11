<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\Alumnus;
use Francken\Extern\Http\Requests\AlumnusRequest;
use Francken\Extern\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminPartnerAlumniController
{
    public function create(Partner $partner) : View
    {
        return view('admin.extern.partners.alumni.create', [
            'partner' => $partner,
            'alumnus' => new Alumnus(),
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'create'], ['partner' => $partner]), 'text' => 'Add alumnus'],
            ]
        ]);
    }

    public function store(AlumnusRequest $request, Partner $partner) : RedirectResponse
    {
        $alumnus = new Alumnus([
            'member_id' => $request->memberId(),
            'position' => $request->position(),
            'started_position_at' => $request->startedPositionAt(),
            'stopped_position_at' => $request->stoppedPositionAt(),
            'notes' => $request->notes(),
        ]);
        $partner->alumni()->save($alumnus);


        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function edit(Partner $partner, Alumnus $alumnus) : View
    {
        return view('admin.extern.partners.alumni.edit', [
            'partner' => $partner,
            'alumnus' => $alumnus,
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'edit'], ['partner' => $partner, 'alumnus' => $alumnus]), 'text' => 'Edit alumnus'],
            ]
        ]);
    }

    public function update(AlumnusRequest $request, Partner $partner, Alumnus $alumnus) : RedirectResponse
    {
        $alumnus->update([
            'member_id' => $request->memberId(),
            'position' => $request->position(),
            'started_position_at' => $request->startedPositionAt(),
            'stopped_position_at' => $request->stoppedPositionAt(),
            'notes' => $request->notes(),
        ]);

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function destroy(Partner $partner, Alumnus $alumnus) : RedirectResponse
    {
        $alumnus->delete();

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }
}
