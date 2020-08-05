<div class="card-body">
    <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-start align-items-center mb-2">
            <h4 class="font-weight-bold mb-0">
                Signups
            </h4>
           n @if ($activity->signUpSettings !== null)
                @if ($activity->signUpSettings->max_sign_ups !== null)
                    <small class="ml-2 mb-0 d-none">(0 / {{ $activity->signUpSettings->max_sign_ups }})</small>
                @else
                    <small class="ml-2 mb-0">(0 / ∞)</small>
                @endif
            @endif
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
            @else
                <a
                    href="{{ action([\Francken\Association\Activities\Http\AdminSignUpSettingsController::class, 'create'], ['activity' => $activity]) }}"
                    class="btn btn-text btn-sm px-0"
                >
                    <i class="fas fa-plus"></i>
                    Add sign up settings
                </a>
            @endif
        </div>
    </div>

    @if ($activity->signUpSettings !== null)
    <p>
        <strong>Max plus ones per member</strong> {{ $activity->signUpSettings->max_plus_ones_per_member }}
    </p>
    <p>
        <strong>Registration costs</strong>: &euro;{{ number_format($activity->signUpSettings->costs_per_person, 2) }}
    </p>
    @if ($activity->signUpSettings->ask_for_dietary_wishes)
        <p>
            <strong>Dieatary wishes</strong> are asked about
        </p>
    @endif
    @if ($activity->signUpSettings->ask_for_drivers_license)
        <p>
            <strong>Drivers license</strong> is asked about
        </p>
    @endif

    <ul class="list-unstyled">
        <li class="p-2 my-2 bg-light d-flex justify-content-between align-items-center">
            <span>
                Su-Elle Kamps
            </span>
            <div class="ml-auto d-flex align-items-center">
                <a
                    class="btn btn-text text-primary btn-sm"
                    href="{{  action(
                                  [\Francken\Association\Activities\Http\AdminActivitiesController::class, 'edit'],
                                  ['activity' => $activity, 'member' => null]
                                  )
                          }}"
                >
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </li>
        <li class="p-2 my-2 bg-light d-flex justify-content-between align-items-center">
            <span>
                Anna Kenbeek <strong>(+1)</strong>
            </span>
            <div class="ml-auto d-flex align-items-center">
                <a
                    class="btn btn-text text-primary btn-sm"
                    href="{{  action(
                                  [\Francken\Association\Activities\Http\AdminActivitiesController::class, 'edit'],
                                  ['activity' => $activity, 'member' => null]
                                  )
                          }}"
                >
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </li>
        <li class="p-2 my-2 bg-light d-flex justify-content-between align-items-center">
            <span>
                Mark Redeman
                <small class="text-muted">
                    (markredeman@gmail.com)
                </small>
            </span>
            <div class="ml-auto d-flex align-items-center">
                <a
                    class="btn btn-text text-primary btn-sm"
                    href="{{  action(
                                  [\Francken\Association\Activities\Http\AdminActivitiesController::class, 'edit'],
                                  ['activity' => $activity, 'member' => null]
                                  )
                          }}"
                >
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </li>
    </ul>

    <div class="d-flex justify-content-between">
        <div>
            <p class="text-muted mb-0 d-none">
                Registration deadline ends in 2 days
            </p>
            @if ($activity->registration_deadline->isFuture())
                <p class="text-muted mb-0">
                    Registration deadline ends in {{ $activity->registration_deadline->diffForHumans() }}
                </p>
            @else
                <p class="text-muted mb-0">
                    Registration deadline ended {{ $activity->registration_deadline->diffForHumans() }}
                </p>
            @endif
        </div>
        <button class="btn btn-text text-primary">
            <i class="fas fa-plus"></i>
            Add signup
        </button>
    </div>
    @endif
</div>
