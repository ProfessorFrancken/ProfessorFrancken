<div class="card-body">
    @if ($activity->signUpSettings === null)
        <div class="bg-light text-center">
            <a
                href="{{ action([\Francken\Association\Activities\Http\AdminSignUpSettingsController::class, 'create'], ['activity' => $activity]) }}"
                class="btn btn-text btn-sm px-0 font-weight-bold text-primary btn-block p-5"
            >
                <i class="fas fa-plus"></i>
                Add sign up settings
            </a>
        </div>
    @endif

    @if ($activity->signUpSettings !== null)
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex justify-content-start align-items-center">
                <h4 class="font-weight-bold mb-0">
                    Sign ups
                    @if ($activity->signUpSettings->max_sign_ups === null)
                        <small class="mx-1 mb-0 text-muted">({{ $activity->totalSignUps }} / ∞)</small>
                    @else
                        <small class="mx-1 mb-0 text-muted">({{ $activity->totalSignUps }} / {{ $activity->signUpSettings->max_sign_ups }})</small>
                    @endif
                    @if ($activity->signUpSettings->ask_for_dietary_wishes)
                        <small class="mx-1">
                            <i class="fas fa-utensils fa-xs text-muted" title="Members are asked about dietary wishes"></i>
                        </small>
                    @endif
                    @if ($activity->signUpSettings->ask_for_drivers_license)
                        <small class="mx-1">
                            <i class="fas fa-car fa-xs text-muted" title="Members are asked if they have a drivers license"></i>
                        </small>
                    @endif
                </h4>
            </div>

            <div class="mb-0">
                @if ($activity->signUpSettings !== null)
                    <a
                        href="{{ action([\Francken\Association\Activities\Http\AdminSignUpSettingsController::class, 'edit'], ['activity' => $activity]) }}"
                        class="btn btn-text btn-sm px-0"
                    >
                        <i class="fas fa-edit"></i>
                        Edit sign up settings
                    </a>
                @endif
            </div>
        </div>

        <p>
            <strong>Registration deadline</strong>:
            @if ($activity->registration_deadline->isFuture())
                 ends in {{ $activity->registration_deadline->diffForHumans() }}
            @else
                ended {{ $activity->registration_deadline->diffForHumans() }}
            @endif
        </p>
        <p>
            <strong>Registration costs</strong>:
            &euro;{{ number_format($activity->signUpSettings->costs_per_person, 2) }}
        </p>
        @if ($activity->signUpSettings->max_plus_ones_per_member !== null)
            <p>
                <strong>Max plus ones per member</strong>:
                {{ $activity->signUpSettings->max_plus_ones_per_member }}
            </p>
        @endif

        @include('admin.association.activities.sign-ups.index', ['activity' => $activity])
    @endif
</div>
