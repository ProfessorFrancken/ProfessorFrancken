<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Francken\Association\Symposium\Participant;
use Francken\Association\Symposium\Symposium;
use Francken\Shared\Email;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AdminSymposiumParticipantsController
{
    public function create(Symposium $symposium) : View
    {
        return view('admin.association.symposia.participants.create', [
            'symposium' => $symposium,
            'participant' => new Participant(),
            'breadcrumbs' => [
                ['url' => action([AdminSymposiaController::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([AdminSymposiaController::class, 'show'], $symposium->id), 'text' => $symposium->name],
                ['url' => action([static::class, 'create'], $symposium->id), 'text' => 'Add participant'],
            ]
        ]);
    }

    public function edit(Symposium $symposium, Participant $participant) : View
    {
        return view('admin.association.symposia.participants.edit', [
            'symposium' => $symposium,
            'participant' => $participant,
            'breadcrumbs' => [
                ['url' => action([AdminSymposiaController::class, 'index']), 'text' => 'Symposia'],
                ['url' => action([AdminSymposiaController::class, 'show'], $symposium->id), 'text' => $symposium->name],
                ['url' => action([AdminSymposiaController::class, 'show'], $symposium->id), 'text' => 'Participants'],
                ['url' => action([static::class, 'edit'], [$symposium->id, $participant->id]), 'text' => $participant->fullname],
            ]
        ]);
    }

    public function store(Symposium $symposium, Request $request) : RedirectResponse
    {
        $participant = $symposium->registerParticipant(
            $request->input('firstname'),
            $request->input('lastname'),
            new Email($request->input('email')),
            $request->has('is_francken_member'),
            $request->has('is_nnv_member'),
            $request->input('nnv_number'),
            $request->has('pays_with_iban'),
            $request->input('iban')
        );

        if ($request->filled('member_id')) {
            $participant->update([
                'member_id' => $request->input('member_id')
            ]);
        }

        return redirect()->action([AdminSymposiaController::class, 'show'], $symposium->id);
    }

    public function update(Symposium $symposium, Participant $participant, Request $request) : RedirectResponse
    {
        $paysWithIban = $request->has('pays_with_bian');
        $isFranckenMember = $request->has('is_francken_member');
        $isNnvMember = $request->has('is_nnv_member');

        $participant->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'is_francken_member' => $isFranckenMember,
            'is_nnv_member' => $isNnvMember,
            'nnv_number' => $request->input('nnv_number'),
            'member_id' => $request->input('member_id'),
            'pays_with_iban' => $paysWithIban,
            'iban' => encrypt($request->input('iban')),
        ]);

        return redirect()->action([AdminSymposiaController::class, 'show'], $symposium->id);
    }

    public function remove(Symposium $symposium, Participant $participant) : RedirectResponse
    {
        $participant->delete();

        return redirect()->action([AdminSymposiaController::class, 'show'], $symposium->id);
    }

    public function toggleSpam(Symposium $symposium, Participant $participant) : RedirectResponse
    {
        $participant->update([
            'is_spam' => ! $participant->is_spam
        ]);

        return redirect()->action([AdminSymposiaController::class, 'show'], $symposium->id);
    }
}
