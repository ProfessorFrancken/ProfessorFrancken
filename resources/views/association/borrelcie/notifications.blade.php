<ul class="list-unstyled mb-0">
    @foreach($notifications as $anytimer)
        <li class="shadow-sm bg-white p-3 d-flex justify-content-between my-4">
            <div>
                <p class="mb-2">
                    @if ($anytimer->context === 'given')
                        <strong>{{ $anytimer->drinker->member->fullname }}</strong>
                        gave you {{ $anytimer->amount }} anytimers.
                    @elseif ($anytimer->context === 'drank')
                        <strong>{{ $anytimer->drinker->member->fullname }}</strong>
                        drank an anytimer from you.
                    @elseif ($anytimer->context === 'claimed')
                        <strong>{{ $anytimer->owner->member->fullname }}</strong>
                        claimed {{ $anytimer->amount }} anytimers on you.
                    @elseif ($anytimer->context === 'used')
                        <strong>{{ $anytimer->owner->member->fullname }}</strong>
                        used an anytimer on you.
                    @endif
                </p>
                <small class="mb-0">
                    {{ $anytimer->created_at->diffForHumans() }}
                    @if ($anytimer->reason)
                        <small class="text-muted font-weight-light mx-1" style="font-size: 0.7rem">
                            •
                        </small>
                        Because: <em>"{{ $anytimer->reason }}"</em>
                    @endif
                </small>
            </div>
            <div class="d-flex justify-contend-end">
                <x-forms.form-button
                    class="btn btn-text btn-sm text-muted"
                    method="PUT"
                    :action="action([\Francken\Association\Borrelcie\Http\AnytimersController::class, 'reject'], ['anytimer' => $anytimer])"
                >
                    <i class="fas fa-times"></i>
                    Reject
                </x-forms.form-button>

                <x-forms.form-button
                    class="btn btn-text btn-sm text-muted"
                    method="PUT"
                    :action="action([\Francken\Association\Borrelcie\Http\AnytimersController::class, 'accept'], ['anytimer' => $anytimer])"
                >
                    <i class="fas fa-check"></i>
                    Accept
                </x-forms.form-button>
            </div>
        </li>
    @endforeach
</ul>
