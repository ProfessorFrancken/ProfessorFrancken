<li class="agenda-item">
    <div class=" d-flex d-flex align-items-center">
        <div class="agenda-item__date align-self-start">
            <h5 class="agenda-item__date-day">{{ $activity->start_date->format('d') }}</h5>
            <span class="agenda-item__date-month">{{ $activity->start_date->format('M') }}</span>
        </div>

        <div class="agenda-item__body">
            <a href="{{ action(
                            [\Francken\Association\Activities\Http\ActivitiesController::class, 'show'] ,
                            ['activity' => $activity]
                        ) }}">
                <h5 class="agenda-item__header">{{ $activity->name }}</h5>
                <p class="agenda-item__description">
                    {{ $activity->summary }}
                </p>
                <small class="mt-1 text-muted font-weight-light d-block">
                    <i class="fas fa-clock"></i>
                    {{ $activity->schedule }}
                </small>
                @if ($activity->location !== '')
                    <small class="mt-1 text-muted font-weight-light">
                        <i class="fas fa-map-marker"></i>
                        {{ $activity->location  }}
                    </small>
                @endif
            </a>
        </div>
    </div>
</li>
