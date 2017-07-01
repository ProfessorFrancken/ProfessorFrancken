<ul class="nav navbar-nav">
    @foreach ($list as $item)
        <li class="sub-menu-item">
            <a href="{{ $item['url'] }}">
                {{ $item['title'] }}
            </a>
        </li>
    @endforeach
</ul>
