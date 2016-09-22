{{-- add `navigation-list__item--active` to the li tag when visiting the associated page --}}
<li class="navigation-list__item clearfix">
    <a class="navigation-list__link" href="{{ $url }}">
        {{ $title }}
    </a>
    @if (isset($subItems))
        <span aria-expanded="false" class="navigation-sub-list__toggle" role="button">
            &nbsp;<span class="caret" aria-expanded="false" role="button"></span>&nbsp;
        </span>

        {{-- may refactored to a horizontal-list --}}
        <ul class="navigation-sub-list">
            @foreach ($subItems as $item)
                <li>
                    <a class="navigation-sub-list__link" href="{{ $item['url'] }}">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
