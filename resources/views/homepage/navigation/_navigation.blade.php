<div class="header__navigation h-100">
    <div class="no-gutters h-100">
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
                        @endforeach
                    </nav>

                    <nav class="navigation__sub-menu nav justify-content-end">
                        @foreach ($items as $item)
                            <?php $active = '/' . Request::segment(1) == $item['url'] ? 'navigation__sub-menu-item--active' : ''; ?>
                                @foreach ($item['subItems'] as $subItem)
                                    <a class="navigation__sub-menu-item nav-link {{ $active }} text-nowrap" href="{{ $subItem['url'] }}">{{ $subItem['title'] }}</a>
                                @endforeach
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
