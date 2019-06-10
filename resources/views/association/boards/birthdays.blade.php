@extends('layout.one-column-layout')

@section('title', "Birthday calendar - T.F.V. 'Professor Francken'")

@section('content')
    <h1 class="section-header">Birthdays</h1>

    <ul class="agenda-list list-unstyled">
        @foreach ($years as $year => $months)
        @foreach ($months as $month => $members)
            <li class="agenda-item d-flex d-flex align-items-center">
                <div class="agenda-item__date align-self-start">
                    <h5 class="agenda-item__date-day">
                        {{ substr($members[0]['day']->format('Y'), -2)  }}
                        {{ $month }}
                    </h5>
                </div>
            </li>
            @foreach ($members as $member)
                <li class="agenda-item d-flex d-flex align-items-center">
                    <div class="agenda-item__date align-self-start">
                        <h5 class="agenda-item__date-day">{{ $member['birthday']->format('j') }}</h5>
                        <span class="agenda-item__date-month">{{ $member['birthday']->format('M') }}</span>
                    </div>

                    <div class="agenda-item__body">
                        <h5 class="agenda-item__header">
                            {{ $member['name'] }}
                            ({{ $today->sub(new \DateInterval('P1D'))->diff($member['birthday'])->format('%y') + 1  }})
                        </h5>
                    </div>
                </li>
            @endforeach
        @endforeach
        @endforeach
    </ul>
@endsection

