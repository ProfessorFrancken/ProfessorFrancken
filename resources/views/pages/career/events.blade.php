@extends('pages.career')
@section('title', "Career events - T.F.V. 'Professor Francken'")

<?php
$plannedExcursions = [
    [
        'name' => 'Excursion to Tata Steel',
        'promo-image' => 'https://upload.wikimedia.org/wikipedia/commons/d/de/CORUS-02.jpg',
        'date' => 'September 14th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Expected number of participants', 'description' => '30'],
            ['term' => 'In collabortaion with', 'description' => '<a href="https://www.gtdbernoulli.nl">G.T.D Bernoulli</a> '],
            ['term' => 'Location', 'description' => 'Ijmuiden'],
            ['term' => 'Expected Date', 'description' => 'September 14th 2017'],
        ]
    ], [
        'name' => 'Material Science excursion',
        'promo-image' => 'http://www.rsp-technology.com/site-media/elements/pictures/header-rsp.jpg',
        'date' => 'September 24th 2017',
        'description' => 'In collaboration with prof. dr. ir. B. J. Kooi an excursion is organised for students attending the coarse Material Science. We will visit two companies, Klesch and RSP both located in Delfzijl.',
        'metadata' => [
            ['term' => 'Expected number of participants', 'description' => '80'],
            ['term' => 'Location', 'description' => 'Delfzijl'],
            ['term' => 'Expected Date', 'description' => 'September 24th 2017'],
        ]
    ], [
        'name' => 'Excursion to Shell',
        'promo-image' => 'http://www.nwtr.nl/images/content/aanvoerwater.jpg',
        'date' => 'Second term of 2017 - 2018',
        'description' => null,
        'metadata' => [
            ['term' => 'Location', 'description' => 'Emmen'],
            ['term' => 'Expected Date', 'description' => 'Second term of 2017 - 2018'],
        ]
    ], [
        'name' => 'Lunch lecture Lambert Instruments',
        'promo-image' => '',
        'date' => 'November 2017',
        'description' => "In November Wopke Hellinga, a recent alumnus of T.F.V. 'Professor Francken' and active member of the Brouwcie, will show us what he's been working on at Lambert Instruments.",
        'metadata' => [
            ['term' => 'Expected Date', 'description' => 'November 2017'],
        ]
    ]
];
?>

@section('board-year-navigation')
    <ol class="list-inline academic-year-list">
        <li class="list-inline-item">
            <a href="#excursions" class="academic-year-list__item academic-year-list__item--disabled" title="Currently we don't have any excursions planned for the academic year of 2018 - 2019">
                2018 - 2019
            </a>
        </li>
        <li class="list-inline-item">
            <strong class="academic-year-list__item academic-year-list__item--active">2017 - 2018</strong>
        </li>
        <li class="list-inline-item">
            <a href="/career/events/2016-2017" class="academic-year-list__item">
                2016 - 2017
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
        Below you'll find a list of planned excursions for the Academic Year of 2017 - 2018 and previously organized excursions.
    </p>

    @yield('board-year-navigation')

    <h2 class="text-center">
        Planned events
    </h2>

    <ul class="list-unstyled">
        @foreach ($plannedExcursions as $excursion)
            @include('pages.career._event', ['excursion' => $excursion])
        @endforeach
    </ul>

    @yield('board-year-navigation')
@endsection
