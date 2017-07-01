@extends('pages.career')


<?php
$pastExcursions = [
    [
        'name' => 'Lunch lecture Magnus',
        'promo-image' => '',
        'date' => 'October 19th 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '25'],
            ['term' => 'Date', 'description' => 'October 19th 2016'],
        ]
    ],
    [
        'name' => 'TMC Lecture',
        'promo-image' => '',
        'date' => 'November 11th 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '14'],
            ['term' => 'Date', 'description' => 'November 11th 2016'],
        ]
    ],
    [
        'name' => 'Expedition Strategy',
        'promo-image' => '',
        'date' => 'November 20th through 24th',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'November 20th through 24th'],
        ]
    ],
    [
        'name' => 'Careerday',
        'promo-image' => '',
        'date' => 'December 1st',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'December 1st'],
        ]
    ],
    [
        'name' => 'Master of Engineering symposium',
        'promo-image' => '',
        'date' => 'December 7th 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'December 7th 2016'],
        ]
    ],
    [
        'name' => 'Thorium lecture',
        'promo-image' => '',
        'date' => 'December 21st 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'December 21st 2016'],
        ]
    ],
    [
        'name' => 'Pre-conference Beta Business Days',
        'promo-image' => '',
        'date' => 'January 12th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'January 12th 2017'],
        ]
    ],
    [
        'name' => 'KNG Lecture "Weer en klimaatextremen"',
        'promo-image' => '',
        'date' => 'January 17th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'January 17th 2017'],
        ]
    ],
    [
        'name' => 'Excursion to AKZO Nobel',
        'promo-image' => '',
        'date' => 'January 19th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'January 19th 2017'],
        ]
    ],
    [
        'name' => 'Beta Business Days',
        'promo-image' => '',
        'date' => 'February 7th & 8th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'February 7th & 8th 2017'],
        ]
    ],
    [
        'name' => 'Excursion to the Innovationcluster Drachten',
        'promo-image' => '',
        'date' => 'February 15th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'February 15th 2017'],
        ]
    ],
    [
        'name' => 'Dance & Dine with Procam',
        'promo-image' => '',
        'date' => 'February 27th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'February 27th 2017'],
        ]
    ],
    [
        'name' => 'Lunch lecture Nedap',
        'promo-image' => '',
        'date' => 'March 20th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'March 20th 2017'],
        ]
    ],
    [
        'name' => 'ASML Physics excursion day',
        'promo-image' => '',
        'date' => 'March 30th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Date', 'description' => 'March 30th 2017'],
        ]
    ],
];
?>

@section('board-year-navigation')
    <ol class="list-inline academic-year-list">
        <li class="list-inline-item">
            <a href="/career/events" class="academic-year-list__item">
                2017 - 2018
            </a>
        </li>
        <li class="list-inline-item">
            <strong class="academic-year-list__item academic-year-list__item--active">
                2016 - 2017
            </strong>
        </li>
        <li class="list-inline-item">
            <a href="/career/events/2015-2016" class="academic-year-list__item">
                2015 - 2016
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <h1 class="section-header section-header--centered" id="excursions">
        Career Events
    </h1>

    <p class="lead">
        At T.F.V. 'Professor Francken' we organize many excursions.
        Below you'll find a list of excursions we organized in the Academic Year of 2016 - 2017.
    </p>


    @yield('board-year-navigation')

    <h2 class="text-center">
        Past events
    </h2>

    <ul class="list-unstyled">
        @foreach ($pastExcursions as $excursion)
            @include('pages.career._event', ['excursion' => $excursion])
        @endforeach
    </ul>

    @yield('board-year-navigation')
@endsection
