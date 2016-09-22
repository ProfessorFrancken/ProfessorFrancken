<li class="top-level-menuitem {{ isset($subItems) ? 'has-sub-menu' : ''  }} clearfix">
    <a class="top-level-link" href="{{ $url }}">
        {{ $title }}
    </a>
    @if (isset($subItems))
        <span aria-expanded="false" class="top-caret" role="button">&nbsp;<i class="menu-caret"></i>&nbsp;</span>
        <ul class="sub-level-menu">
            @foreach ($subItems as $item)
                <li>
                    <a class="sub-level-link" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
