<div class="header__navigation h-100">
    <div class="no-gutters hidden-sm-down h-100">
        <div class="align-items-center h-100">
            <div class="d-flex align-items-center h-100">
                <div class="navigation">
                    <nav class="navigation__menu nav justify-content-around">
                        @foreach ($items as $item)
                            <a class="navigation__menu-item nav-link active text-nowrap {{ $item['class'] or '' }}" href="{{ $item['url'] }}">
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
                    </nav>

                    <nav class="navigation__sub-menu nav justify-content-end">
                        @stack('sub-navigation-items')
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
