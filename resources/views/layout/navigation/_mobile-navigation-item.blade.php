{{-- Check whether this url or one of its siblings is being visited --}}
<?php $active = '/' . Request::segment(1) == $url; ?>

<li class="navigation-list__item clearfix">
    <a class="navigation-list__link {{ $class ?? '' }}" href="{{ $url }}">
        @if ($icon != '')
             <i class="fa fa-{{ $icon }}" aria-hidden="true"></i>
            {{-- <img src="/icons/filled/{{ $item['icon'] }}.svg" alt="" style="height: 20px" class="mr-2"> --}}
        @endif

        {{ $title }}
    </a>
    @if (isset($subItems) && count($subItems) > 0)
        <span aria-expanded="false" class="navigation-sub-list__toggle" role="button">
            &nbsp;<span class="caret" aria-expanded="false" role="button"></span>&nbsp;
        </span>

        {{-- may refactored to a horizontal-list --}}
        <ul class="navigation-sub-list">
            @foreach ($subItems as $item)
                <li>
                    <a class="navigation-sub-list__link" href="{{ $item['url'] }}">

                        @if ($item['icon'] != '')
                            <i class="fa fa-{{ $item['icon'] }} fa-fw text-muted" aria-hidden="true"></i>
                        @endif

                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
