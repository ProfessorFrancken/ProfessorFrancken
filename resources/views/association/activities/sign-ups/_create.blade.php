{!!
       Form::open([
           'url' => action(
               [\Francken\Association\Activities\Http\SignUpsController::class, 'store'],
               ['activity' => $activity]
           ),
       ])
!!}
@include('association.activities.sign-ups._form', ['activity' => $activity])

<p class="mt-3">
    <button class="btn btn-primary mr-3" type="submit">
        Sign up
    </button>
    The sign up deadline ends in {{ $activity->registration_deadline->diffForHumans() }}
</p>

{!! Form::close() !!}
