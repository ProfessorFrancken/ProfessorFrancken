<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use DateTimeImmutable;
use Francken\Association\Symposium\Participant;
use Francken\Association\Symposium\Symposium;
use Francken\Shared\Email;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ParticipantRegistrationController
{
    public function store(Symposium $symposium, Request $request) : JsonResponse
    {
        $participant = $symposium->registerParticipant(
            $request->input('firstname'),
            $request->input('lastname'),
            new Email($request->input('email')),
            $request->has('is_francken_member'),
            $request->has('is_nnv_member'),
            $request->input('nnv_number'),
            $request->input('payment_method', 'debit') !== 'cash',
            $request->input('iban')
        );

        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Called when verifying the registration status of a participant
     */
    public function verify(Symposium $symposium, Participant $participant) : RedirectResponse
    {
        $participant->verifyRegistration(new DateTimeImmutable());

        return redirect('https://franckensymposium.nl/thanks');
    }
}
