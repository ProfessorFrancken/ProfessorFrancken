{{-- add `active-menu-item` to the li tag when visiting the associated page --}}
<li class="top-level-menuitem active-menu-item clearfix">
    <a class="top-level-link" href="{{ $url }}">
        {{ $title }}
    </a>
    @if (isset($subItems))
        <span aria-expanded="false" class="top-caret" role="button">
            &nbsp;<i class="menu-caret"></i>&nbsp;
        </span>
        <ul class="sub-level-menu">
            @foreach ($subItems as $item)
                <li>
                    <a class="sub-level-link" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
