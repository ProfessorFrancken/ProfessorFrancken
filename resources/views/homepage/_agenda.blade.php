<?php

$activities = [
    [
        'date' => new \DateTimeImmutable('01-09-2017'),
        'title' => 'Pienterkamp',
        'short-description' => 'Introduction camp for (Applied) Mathematics and (Applied) Physics.',
    ],
    [
        'date' => new \DateTimeImmutable('04-09-2017'),
        'title' => "Free tosties",
        'short-description' => "Get your free tosti during the first week in the Franckenboom",
    ],
    [
        'date' => new \DateTimeImmutable('05-09-2017'),
        'title' => 'Cocktailborrel',
        'short-description' => 'Drink some cocktails after your lectures at Francken',
    ],
    [
        'date' => new \DateTimeImmutable('07-09-2017'),
        'title' => '1st Years Applied Physics Burger Night',
        'short-description' => 'Eat some burgers at the Papa Joe steak restaurant',
    ],
    [
        'date' => new \DateTimeImmutable('11-09-2017'),
        'title' => 'Werewolves of Franckendam',
        'short-description' => '',
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
        <li class="agenda-item d-flex d-flex align-items-center">
            <div class="agenda-item__date align-self-start">
                <h5 class="agenda-item__date-day">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                </h5>
            </div>

            <div class="agenda-item__body">
                <a href="https://calendar.google.com/calendar/ical/g8f50ild2kdf49bgathcdhvcqc%40group.calendar.google.com/public/basic.ics">
                    <h5 class="agenda-item__header">Download our ical</h5>
                    <p class="agenda-item__description">
                        Upload our agenda to your own by downloading our ical
                    </p>
                </a>
            </div>
        </li>
    </ul>
</div>
