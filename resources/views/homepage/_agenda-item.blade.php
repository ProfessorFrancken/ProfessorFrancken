<li class="agenda-item">
    <div class=" d-flex d-flex align-items-start">
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
                <div class="d-flex align-items-center mt-2 mb-1">
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
                @if ($activity->signUpSettings !== null)
                    <small class="text-muted font-weight-light">
                        <i class="fas fa-clock"></i>
                        Registration ends in {{ $activity->signUpSettings->deadline_at->diffForHumans() }}
                    </small>
                @endif
            </a>
        </div>
    </div>
</li>
