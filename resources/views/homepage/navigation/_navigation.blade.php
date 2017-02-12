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

?>

<div class="header__navigation h-100">
    <div class="row no-gutters hidden-sm-down h-100">
        <div class="col align-items-center h-100">
            <div class="d-flex align-items-center h-100">
                <div class="navigation col-md-9">
                    <nav class="navigation__menu nav justify-content-around">
                        @foreach ($items as $item)

                            <a class="navigation__menu-item nav-link active text-nowrap" href="{{ $item['url'] }}">
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


                        @if (Auth::check())
                            <a class="navigation__menu-item nav-link text-nowrap" href="https://www.flickr.com/photos/fotocie/sets/">
                                <i class="fa fa-camera mr-2" aria-hidden="true"></i>
                                Photos
                            </a>
                            <a class="navigation__menu-item nav-link text-nowrap" href="/logout">
                                <i class="fa fa-user mr-2" aria-hidden="true"></i>
                                Profile
                            </a>
                        @else
                            <a class="navigation__menu-item nav-link login-link" href="/login">
                                <i class="fa fa-user mr-2" aria-hidden="true"></i>
                                Login
                            </a>
                        @endif

                    </nav>

                    <nav class="navigation__sub-menu nav justify-content-end">
                        @stack('sub-navigation-items')
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
