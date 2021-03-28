<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Francken\Association\Symposium\Http\Requests\ParticipantRequest;
use Francken\Association\Symposium\Participant;
use Francken\Association\Symposium\Symposium;
use Illuminate\Http\RedirectResponse;
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

    public function store(Symposium $symposium, ParticipantRequest $request) : RedirectResponse
    {
        $participant = $symposium->registerParticipant(
            $request->firstname(),
            $request->lastname(),
            $request->email(),
            $request->isFranckenMember(),
            $request->isNNVMember(),
            $request->NNVNumber(),
            $request->paysWithIban(),
            $request->iban(),
            $request->freeLunch(),
            $request->freeBorrelbox()
        );

        if ($request->filled('member_id')) {
            $participant->update([
                'member_id' => $request->memberId()
            ]);
        }

        return redirect()->action([AdminSymposiaController::class, 'show'], $symposium->id);
    }

    public function update(Symposium $symposium, Participant $participant, ParticipantRequest $request) : RedirectResponse
    {
        $participant->update([
            'firstname' => $request->firstname(),
            'lastname' => $request->lastname(),
            'email' => $request->email()->toString(),
            'is_francken_member' => $request->isFranckenMember(),
            'is_nnv_member' => $request->isNNVMember(),
            'nnv_number' => $request->NNVNumber(),
            'member_id' => $request->memberId(),
            'pays_with_iban' => $request->paysWithIban(),
            'iban' => encrypt($request->iban()),

            'free_lunch' => $request->freeLunch(),
            'free_borrelbox' => $request->freeBorrelbox(),
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
