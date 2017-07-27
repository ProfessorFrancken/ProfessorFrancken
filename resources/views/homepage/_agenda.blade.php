<?php

$activities = [
    [
        'date' => new \DateTimeImmutable('31-07-2017'),
        'title' => 'Watch Game of Thrones at Francken',
        'short-description' => '',
    ],
    [
        'date' => new \DateTimeImmutable('07-08-2017'),
        'title' => 'Watch Game of Thrones at Francken',
        'short-description' => '',
    ],
    [
        'date' => new \DateTimeImmutable('14-08-2017'),
        'title' => 'Watch Game of Thrones at Francken',
        'short-description' => '',
    ],
    [
        'date' => new \DateTimeImmutable('14-08-2017'),
        'title' => 'KEI-week 2017',
        'short-description' => '',
    ],
    [
        'date' => new \DateTimeImmutable('21-08-2017'),
        'title' => 'Watch Game of Thrones at Francken',
        'short-description' => '',
    ],
    [
        'date' => new \DateTimeImmutable('28-08-2017'),
        'title' => 'Watch Game of Thrones at Francken',
        'short-description' => '',
    ],
    [
        'date' => new \DateTimeImmutable('01-09-2017'),
        'title' => 'Pienterkamp',
        'short-description' => 'Introduction camp for (Applied) Mathematics and (Applied) Physics.',
    ],

];

?>
<div class="agenda">
    <h3 class="section-header agenda-header">
        Agenda
    </h3>
    <ul class="agenda-list list-unstyled">
        @foreach (array_slice($activities, 0, 5) as $activity)
            <li class="agenda-item d-flex d-flex align-items-center">
                <div class="agenda-item__date align-self-start">
                    <h5 class="agenda-item__date-day">{{ $activity['date']->format('d') }}</h5>
                    <span class="agenda-item__date-month">{{ $activity['date']->format('M') }}</span>
                </div>

                <div class="agenda-item__body">
                    <h5 class="agenda-item__header">{{ $activity['title'] }}</h5>
                    <p class="agenda-item__description">
                        {{ $activity['short-description'] }}
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
