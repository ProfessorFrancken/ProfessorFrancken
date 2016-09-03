{{--
    This partial can be used to create a sub navigaiton menu
    Call it using,

    @include('layout._subnavigation', [
        'list' => [
            ['url' => '/history', 'title' => 'History'],
            ['url' => '/honorary-members', 'title' => 'Honerary members']
        ]
    ])
--}}

<ul class="nav navbar-nav">
    @foreach ($list as $item)
        <li class="sub-menu-item">
            <a href="{{ $item['url'] }}">
                {{ $item['title'] }}
            </a>
        </li>
    @endforeach
</ul>
