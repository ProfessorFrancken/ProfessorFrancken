{!!
       Form::open([
           'url' => action(
               [\Francken\Association\Activities\Http\SignUpsController::class, 'store'],
               ['activity' => $activity]
           ),
       ])
!!}

<h5 class="d-flex justify-content-between">
    <span>
    Sign up for {{ $activity->name }}
    </span>

@if (! $activity->signUpSettings->is_free)
    <small class="text-muted font-weight-light mt-2">
        Costs: <i class="fas fa-euro-sign"></i>
        {{ number_format($activity->signUpSettings->costs_per_person / 100, 2) }}
        per person
    </small>
@endif
</h5>


@if ($activity->signUpSettings->allows_plus_ones)
<div class="form-group">
    <label for="plus_ones">Are you brining anyone?</label>
    {!!
           Form::number(
               'plus_ones',
               0,
               ['class' => 'form-control', 'id' => 'plus_ones']
           )
    !!}
</div>
@endif

@if ($activity->signUpSettings->ask_for_dietary_wishes)
    <div class="form-group">
        <label for="dietary_wishes">Dietary wishes</label>
        {!!
               Form::text(
                   'dietary_wishes',
                   null,
                   ['class' => 'form-control', 'id' => 'dietary_wishes']
               )
        !!}
    </div>
@endif
@if ($activity->signUpSettings->ask_for_drivers_license)
    <div class="form-group form-check">
        {!!
               Form::checkbox(
                   'has_drivers_license',
                   true,
                   null,
                   ['class' => 'form-check-input', 'id' => 'has_drivers_license']
               )
        !!}
        <label class="form-check-label" for="has_drivers_license">
            Do you have a drivers license?
        </label>
    </div>
@endif

<p class="mt-3">
    <button class="btn btn-primary mr-3">
        Sign up
    </button>
    The sign up deadline ends in {{ $activity->registration_deadline->diffForHumans() }}
</p>

{!! Form::close() !!}
