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
    <?php $active = '/' . Request::segment(1) . '/' . Request::segment(2) == $url; ?>
    <li class="navigation-desktop-list__item {{ $active ? 'navigation-desktop-list__item--active' : '' }}">
        <a class="navigation-desktop-list__link" href="{{ $url }}">
            {{ $title }}
        </a>
    </li>
    @endpush
@endif
