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

<div class="header__navigation h-100">
    <div class="no-gutters hidden-sm-down h-100">
        <div class="align-items-center h-100">
            <div class="d-flex align-items-center h-100">
                <div class="navigation">
                    <nav class="navigation__menu nav justify-content-around">
                        @foreach ($items as $item)
                            <a class="navigation__menu-item nav-link active text-nowrap {{ $item['class'] or '' }}" href="{{ $item['url'] }}">
                                @if ($item['icon'] != '')
                                    <i class="fa fa-{{ $item['icon'] }} mr-2" aria-hidden="true"></i>
                                @endif
                                {{ $item['title'] }}
                            </a>

                            @if ('/' . Request::segment(1) == $item['url'])
                                @foreach ($item['subItems'] as $subItem)
                                    @push('sub-navigation-items')
                                        <a class="navigation__sub-menu-item nav-link active text-nowrap" href="{{ $subItem['url'] }}">{{ $subItem['title'] }}</a>
                                    @endpush
                                @endforeach
                            @endif
                        @endforeach
                    </nav>

                    <nav class="navigation__sub-menu nav justify-content-end">
                        @stack('sub-navigation-items')
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
