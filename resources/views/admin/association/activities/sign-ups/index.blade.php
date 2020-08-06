<ul class="list-unstyled mb-0">
    @foreach ($activity->signUps as $signUp)
        <li class="p-3 my-2 bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    {{ $signUp->member->fullname }}
                    @if ($signUp->plus_ones > 0)
                        <strong>(+{{ $signUp->plus_ones }})</strong>
                    @endif
                    <small class="text-muted mx-1">
                        ({{ $signUp->member->email->toString() }})
                    </small>
                    @if ($signUp->has_drivers_license)
                        <i class="fas fa-car text-muted ml-1" title="Has a drivers license"></i>
                    @endif
                </h5>
                <div class="ml-auto d-flex align-items-center">
                    <a
                        class="btn btn-text text-primary btn-sm"
                        href="{{  action(
                                      [\Francken\Association\Activities\Http\AdminSignUpsController::class, 'edit'],
                                      ['activity' => $activity, 'sign_up' => $signUp]
                                      )
                              }}"
                    >
                        Edit
                        <i class="fas fa-edit ml-1"></i>
                    </a>
                </div>
            </div>
            @if ($signUp->dietary_wishes !== '')
                <p class="mb-0 mt-2">
                    <i class="fas fa-utensils fa-fw text-muted" title="Dietary wishes"></i>
                    {{ $signUp->dietary_wishes }}
                </p>
            @endif
        </li>
    @endforeach
</ul>

<div class="d-flex justify-content-between">
    <a class="btn btn-text text-primary"
        href="{{  action(
                      [\Francken\Association\Activities\Http\AdminSignUpsController::class, 'create'],
                      ['activity' => $activity]
                      )
              }}"
    >
        <i class="fas fa-plus"></i>
        Add sign up
    </a>
</div>

