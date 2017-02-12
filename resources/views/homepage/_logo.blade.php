<?php

$items = [
    [
        'url' => '/study',
        'title' => 'Study',
        'subItems' => [
            ['url' => "/study/books", 'title' => 'Books'],
            ['url' => "/study/research-groups", 'title' => 'Research Groups'],
            ['url' => "/study/representation/university-council", 'title' => 'University Council'],
            ['url' => "/study/representation/faculty-council", 'title' => 'Faculty Council'],
        ],
        'icon' => 'book',
    ],
    [
        'url' => '/association',
        'title' => 'Association',
        'subItems' => [
            ['url' => "/association/news", 'title' => 'News'],
            ['url' => "/association/history", 'title' => 'History'],
            ['url' => "/association/honorary-members", 'title' => 'Honerary members'],
            ['url' => "/association/boards", 'title' => 'Boards'],
            ['url' => "/association/committees", 'title' => 'Committees'],
            ['url' => "/association/francken-vrij", 'title' => 'Francken Vrij']
        ],
    //    'icon' => 'beer',
        'icon' => 'coffee',
    ],
    [
        'url' => '/career',
        'title' => 'Career',
        'subItems' => [
            ['url' => "/career/job-openings", 'title' => 'Job openings'],
            ['url' => "/career/companies", 'title' => 'Company profiles'],
            ['url' => "/career/excursions", 'title' => 'Excursions']
        ],
        'icon' => 'briefcase',
    ],
];

if (Auth::check()) {
    $items[] = [
        'url' => 'https://www.flickr.com/photos/fotocie/sets/',
        'title' => 'Photos',
        'subItems' => [],
        'icon' => 'camera',
    ];

    $items[] = [
        'url' => '/logout',
        'title' => 'Profile',
        'subItems' => [],
        'icon' => 'user',
    ];
} else {
    $items[] = [
        'url' => '/login',
        'title' => 'Login',
        'subItems' => [],
        'icon' => 'user',
        'class' => 'login-link'
    ];
}

?>

@section('hamburger-menu-2')
    {{-- This section adds the Hamburger menu --}}
    <div class="navigation__mobile-menu">
        <button id="navbar-toggler-2" class="hamburger-menu">
            <span class="hamburger-menu__line"></span>
            <span class="hamburger-menu__line"></span>
            <span class="hamburger-menu__line"></span>
        </button>
    </div>
@endsection

@section('menu-items-2')
    {{--

        This section contains all of the menu items
        We're using partial views so we can focus on
        the structure on the menu

    --}}
    <ul class="navigation-list clearfix" id="main-menu">
        @foreach ($items as $item)
            @include('homepage._mobile-navigation-item', [
                'url' => $item['url'],
                'title' => $item['title'],
                'icon' => $item['icon'],
                'subItems' => $item['subItems'],
            ])
        @endforeach
    </ul>
@endsection

<div class="skew-md--top-right header__logo">
    <a class="header__title-link align-items-center align-middle d-inline-flex" href="/">
        <img alt="Logo of T.F.V. 'Professor Francken'" src="/images/LOGO_KAAL.png" class="img-fluid" />
        <h1 class="header__title text-center float-right ">
            T.F.V.<br class="hidden-md-down"/>
            'Professor<br class="hidden-md-down"/>
            Francken'
        </h1>
    </a>

    <div class="old-menu"
    >
        @yield('hamburger-menu-2')
        @yield('menu-items-2')
    </div>
</div>
