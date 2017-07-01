@extends('pages.career')

<?php
$pastExcursions = [
    [
        'name' => 'Lunch lecture Thales',
        'promo-image' => '',
        'date' => 'September 22th 2015',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '30'],
            ['term' => 'Date', 'description' => 'September 22th 2015'],
        ]
    ],
    [
        'name' => 'Excursion to DNB/Kempen & Co',
        'promo-image' => '',
        'date' => 'October 15th & 16th 2015',
        'description' => null,
        'metadata' => [
            ['term' => 'Participants from Francken', 'description' => '8'],
            ['term' => 'Location', 'description' => 'Amsterdam'],
            ['term' => 'Date', 'description' => 'October 15th & 16th 2015'],
        ]
    ],
    [
        'name' => 'Lunch lecture TMC',
        'promo-image' => '',
        'date' => 'November 24th 2015',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '34'],
            ['term' => 'Date', 'description' => 'November 24th 2015'],
        ]
    ],
    [
        'name' => 'Lunch lecture Masters of Engineering',
        'promo-image' => '',
        'date' => 'December 3rd 2015',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '50'],
            ['term' => 'Date', 'description' => 'December 3rd 2015'],
        ]
    ],
    [
        'name' => 'Lunch lecture Eerst De Klas',
        'promo-image' => '',
        'date' => 'February 9th 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '16'],
            ['term' => 'Date', 'description' => 'February 9th 2016'],
        ]
    ],
    [
        'name' => 'Excursion to Philips',
        'promo-image' => '',
        'date' => 'February 18th 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '15'],
            ['term' => 'Location', 'description' => 'Drachten'],
            ['term' => 'Date', 'description' => 'February 18th 2016'],
        ]
    ],
    [
        'name' => 'Lunch lecture ASML',
        'promo-image' => '',
        'date' => 'February 22nd 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '40'],
            ['term' => 'Expected Date', 'description' => 'February 22nd 2016'],
        ]
    ],
    [
        'name' => 'Lunch lecture Topicus',
        'promo-image' => '',
        'date' => 'March 8th 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '22'],
            ['term' => 'Date', 'description' => 'March 8th 2016'],
        ]
    ],
    [
        'name' => 'Beta Business Days',
        'promo-image' => '',
        'date' => 'March 22th & 23th 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '700'],
            ['term' => 'Date', 'description' => 'March 22th & 23th 2016'],
        ]
    ],
    [
        'name' => 'Excursion to ASML',
        'promo-image' => '',
        'date' => 'April 21st 2016',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '32'],
            ['term' => 'Location', 'description' => 'Veldhoven'],
            ['term' => 'Expected Date', 'description' => 'April 21st 2016'],
        ]
    ],
    [
        'name' => 'Excursion to Nedap',
        'promo-image' => 'May 3rd 2016',
        'date' => '',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '16'],
            ['term' => 'Location', 'description' => 'Groenlo'],
            ['term' => 'Expected Date', 'description' => 'May 3rd 2016'],
        ]
    ],
    [
        'name' => 'Excursion to Schut',
        'promo-image' => 'May 31st 2016',
        'date' => '',
        'description' => null,
        'metadata' => [
            ['term' => 'Number of participants', 'description' => '10'],
            ['term' => 'Location', 'description' => 'Groningen'],
            ['term' => 'Expected Date', 'description' => 'May 31st 2016'],
        ]
    ],
];
?>

@section('board-year-navigation')
    <ol class="list-inline academic-year-list">
        <li class="list-inline-item">
            <a href="/career/events/2016-2017" class="academic-year-list__item">
                2016 - 2017
            </a>
        </li>
        <li class="list-inline-item">
            <strong class="academic-year-list__item academic-year-list__item--active">
                2015 - 2016
            </strong>
        </li>
        <li class="list-inline-item">
            <a href="#excursions" class="academic-year-list__item academic-year-list__item--disabled">
                2014 - 2015
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
        Below you'll find a list of excursions we organized in the Academic Year of 2015 - 2016.
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
