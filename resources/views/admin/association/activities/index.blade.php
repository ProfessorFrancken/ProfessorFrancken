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
                                {{ $activity->start_date->format("Y-m-d") }}
                                </div>
                                <small class="text-muted">
                                {{ $activity->start_date->format("H:i") }}
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
                                            {{ $activity->name }}
                                        </span>
                                    </h4>
                                    <p class="text-muted my-0">
                                        {{ $activity->summary }}
                                    </p>
                                    <p class="text-muted my-0">
                                        @if ($activity->location)
                                            <i class="fas fa-xs fa-map-marker"></i>
                                            {{ $activity->location }}
                                        @endif
                                    </p>
                                </a>
                            </td>
                            <td class="text-right">
                                @if ($activity->signUpSettings)
                                <p class="my-0">
                                    {{ $activity->total_sign_ups }} / {{ $activity->signUpSettings->max_sign_ups }}
                                </p>
                                <small class="text-muted my-0">
                                    @if ($activity->signUpSettings->deadline_at->isFuture())
                                        Registration ends in {{ $activity->signUpSettings->deadline_at->diffForHumans() }}
                                    @else
                                        Registration closed
                                    @endif
                                </small>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $activities->links() }}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Association\Activities\Http\AdminActivitiesController::class, 'create']) }}"
           class="btn btn-primary btn-sm"
        >
            <i class="fas fa-plus"></i>
            Plan new activity
        </a>
    </div>
@endsection
