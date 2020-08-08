@extends('layout.two-column-layout')
@section('title', 'Change sign up for ' . $activity->name . " - T.F.V. 'Professor Francken'")

    @section('content')
        <div class="rounded shadow-sm">
            <div class="bg-white p-4 ">
                {!!
                       Form::model($signUp, [
                           'url' => action(
                               [\Francken\Association\Activities\Http\SignUpsController::class, 'update'],
                               ['activity' => $activity, 'sign_up' => $signUp]
                           ),
                           'method' => 'PUT'
                       ])
                !!}
                @include('association.activities.sign-ups._form', ['activity' => $activity, 'signUp' => $signUp])


                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <button class="btn btn-primary mr-3" type="submit">
                            Save
                        </button>
                    </div>
                </div>

                {!! Form::close() !!}
<div class="">
                    {!!
                           Form::model(
                               $signUp,
                               [
                                   'url' => action(
                                       [\Francken\Association\Activities\Http\SignUpsController::class, 'destroy'],
                                       ['activity' => $activity, 'sign_up' => $signUp]
                                   ),
                                   'method' => 'post'
                               ]
                           )
                    !!}
                    @method('DELETE')
                    <div>
                        <button class="btn btn-text px-1">
                            Cancel your sign up
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>



            </div>
    </div>

@endsection

@section('aside')
    <div class="agenda">
        <h3 class="section-header agenda-header">
            Calendar
        </h3>
        <ul class="agenda-list list-unstyled">
            <div class="agenda-item d-flex justify-content-between font-weight-bold mb-2 pb-2">
                @include('association.activities._sidebar-years', ['years' => $visibleYears])
            </div>
            @foreach ($months as $month)
                @include('association.activities._sidebar-month', [
                    'year' => $selectedYear, 'month' => $month
                    ])
            @endforeach
        </ul>
    </div>
@endsection
