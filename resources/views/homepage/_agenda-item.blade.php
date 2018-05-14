<li class="agenda-item">
    <div class=" d-flex d-flex align-items-center">
        <div class="agenda-item__date align-self-start">
            <h5 class="agenda-item__date-day">{{ $activity->startDate()->format('d') }}</h5>
            <span class="agenda-item__date-month">{{ $activity->startDate()->format('M') }}</span>
        </div>

        <div class="agenda-item__body">
            <h5 class="agenda-item__header">{{ $activity->title() }}</h5>
            <p class="agenda-item__description">
                {{ $activity->shortDescription() }}
            </p>
            <small class="mt-1 text-muted font-weight-light d-block">
                <i class="fas fa-clock"></i>
                {{ $activity->schedule() }}
            </small>
            @if ($activity->location() !== '')
                <small class="mt-1 text-muted font-weight-light">
                    <i class="fas fa-map-marker"></i>
                    {{ $activity->location()  }}
                </small>
            @endif
        </div>
    </div>
</li>
