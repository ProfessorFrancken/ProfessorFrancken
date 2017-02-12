<?php

$items = [
    [
        'url' => '/study',
        'title' => 'Study',
        'subItems' => [
            ['url' => "/study/books", 'title' => 'Books'],
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

?>

<div class="header__navigation h-100">
    <div class="row no-gutters hidden-sm-down h-100">
        <div class="col align-items-center h-100">
            <div class="d-flex align-items-center h-100">
                <div class="navigation col-md-9">
                    <nav class="navigation__menu nav justify-content-around">
                        @foreach ($items as $item)

                            <a class="navigation__menu-item nav-link active" href="{{ $item['url'] }}">
                                @if ($item['icon'] != '')
                                    <i class="fa fa-{{ $item['icon'] }} mr-2" aria-hidden="true"></i>
                                @endif
                                {{ $item['title'] }}
                            </a>

                            @if ('/' . Request::segment(1) == $item['url'])
                                @foreach ($item['subItems'] as $subItem)
                                    @push('sub-navigation-items')
                                        <a class="navigation__sub-menu-item nav-link active" href="{{ $subItem['url'] }}">{{ $subItem['title'] }}</a>
                                    @endpush
                                @endforeach
                            @endif
                        @endforeach

                        <a class="navigation__menu-item nav-link disabled" href="https://www.flickr.com/photos/fotocie/sets/">Photos</a>

                        <a class="navigation__menu-item nav-link login-link" href="#">
                            Login
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                        </a>
                    </nav>

                    <nav class="navigation__sub-menu nav justify-content-end">
                        @stack('sub-navigation-items')
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
