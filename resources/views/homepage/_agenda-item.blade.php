<li class="px-5 my-4">
    <div class="d-flex d-flex align-items-start">
        <div class="agenda-item__date align-self-start">
            <h5 class="agenda-item__date-day text-app-secondary">{{ $activity->start_date->format('d') }}</h5>
            <span class="agenda-item__date-month">{{ $activity->start_date->format('M') }}</span>
        </div>

        <a href="{{ action(
                        [\Francken\Association\Activities\Http\ActivitiesController::class, 'show'] ,
                        ['activity' => $activity]
                        ) }}">
            <div class="text-app-secondary-dark d-flex justify-content-start mb-1">
                <div class=" mr-1">
                    @if ($activity->start_date->isToday())
                        Today
                    @elseif ($activity->start_date->isTomorrow())
                        Tomorrow
                    @else
                        {{ $activity->start_date->format('l') }}
                    @endif
                </div>
                <div>
                    - {{ $activity->start_date->format('H:i') }}
                </div>
            </div>
            <h6 class="mb-0">{{ $activity->name }}</h6>
            @if ($activity->signUpSettings !== null)
                @if ($activity->signUpSettings->deadline_at->isCurrentWeek())
                    <small class="text-muted">
                        <i class="fas fa-clock text-primary"></i>
                        Registration ends in {{ $activity->signUpSettings->deadline_at->diffForHumans() }}
                    </small>
                @endif
            @endif
            <div class="d-flex align-items-center mt-2 pt-1 mb-1">
                @if ($activity->signUpSettings !== null)
                    @if ($activity->signUpSettings->is_free)
                        <small class="text-muted">
                            <i class="fas fa-euro-sign"></i>
                            Free
                        </small>
                    @else
                        <small class="text-muted font-weight-light">
                            <i class="fas fa-euro-sign"></i>
                            {{ number_format($activity->signUpSettings->costs_per_person / 100, 2) }}
                        </small>
                    @endif

                    <small class="text-muted font-weight-light mx-2" style="font-size: 0.7rem">
                        •
                    </small>
                    <small class="text-muted font-weight-light">
                        <i class="fas fa-users mr-1"></i>

                        {{ $activity->totalSignUps }} /

                        @if ($activity->signUpSettings->max_sign_ups === null)
                            ∞
                        @else
                            {{ $activity->signUpSettings->max_sign_ups }}
                        @endif
                    </small>
                @endif
                @if ($activity->signUpSettings !== null && $activity->comments_count > 0)
                    <small class="text-muted font-weight-light mx-2" style="font-size: 0.7rem">
                        •
                    </small>
                @endif
                @if ($activity->comments_count > 0)
                    <small class="text-muted font-weight-light">
                        <i class="fas fa-comments"></i>
                        {{ $activity->comments_count  }}
                    </small>
                @endif
            </div>
        </a>
    </div>
</li>
