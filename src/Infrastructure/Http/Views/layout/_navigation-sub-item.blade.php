<li>
    <a class="navigation-sub-list__link" href="{{ $url}}">
        {{ $title }}
    </a>
</li>

{{--
     If this item's parent navigation is active, then show this
     item in the desktop sub list
--}}
@if ($active)
    @push('sub-navigation')
    <li class="navigation-desktop-list__item">
        <a class="navigation-desktop-list__link" href="{{ $url }}">
            {{ $title }}
        </a>
    </li>
    @endpush
@endif
