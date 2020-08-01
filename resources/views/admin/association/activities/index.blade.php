@extends('admin.layout')
@section('page-title', 'Activities')

@section('content')
    <div class="card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>
                        <i class="fas fa-clock"></i>
                        Planned at
                    </th>
                    <th>Activity</th>
                    <th class='text-right'>Registrations</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tbody>
                        <tr class=" border-bottom-0">
                            <td>
                                <div>
                                {{ $activity->startDate()->format("Y-m-d") }}
                                </div>
                                <small class="text-muted">
                                {{ $activity->startDate()->format("H:i") }}
                                </small>
                            </td>
                            <td>
                                <a href="{{ action(
                                                [\Francken\Association\Activities\Http\AdminActivitiesController::class, 'show'],
                                                ['activity' => $activity]
                                                ) }}"
                                >
                                    <h4 class='d-flex flex-column h6 mb-0'>
                                        <span>
                                            {{ $activity->name() }}
                                        </span>
                                    </h4>
                                    <p class="text-muted my-0">
                                        {{ $activity->shortDescription() }}
                                    </p>
                                    <p class="text-muted my-0">
                                        @if ($activity->location())
                                        <i class="fas fa-xs fa-map-marker"></i>
                                        {{ $activity->location() }}
                                        @endif
                                    </p>
                                </a>
                            </td>
                            <td class="text-right">
                                <p class="my-0">
                                    10 / 33
                                </p>
                                <small class="text-muted my-0">
                                    Registration closed
                                </small>
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
