<nav class="navigation__menu nav d-flex justify-content-end" role="navigation">
    @foreach ($items as $item)
        <div class=" navigation__hoverable {{ $loop->last ? '' : '' }}">
            <?php $active = '/' . Request::segment(1) == $item['url'] ? 'navigation__menu-item--active' : ''; ?>
            <a
                class="px-3
                       navigation__menu-item
                       nav-link
                       text-nowrap
                       {{ $active }}
                       {{ $item['class'] ?? '' }}"
                href="{{ $item['url'] }}"
            >
                @if ($item['icon'] != '')
                    <i class="fa fa-{{ $item['icon'] }}" aria-hidden="true"></i>
                @endif
                {{ $item['title'] }}
            </a>

            <ul
                class="list-unstyled navigation__sub-menu nav justify-content-end m-0 p-0 bg-white d-flex flex-column border-right border-left border-bottom"
                style= " border-radius: 0 0 4px 4px; overflow: hidden; "
            >
                <?php $active = '/' . Request::segment(1) == $item['url'] ? 'navigation__sub-menu-item--active' : ''; ?>
                @foreach ($item['subItems'] as $subItem)
                    <li class="border-top">
                        <a
                            class="navigation__sub-menu-item nav-link {{ $active }} text-nowrap p-3 pr-5 align-items-center"
                            href="{{ $subItem['url'] }}"
                        >
                                <div class="d-flex flex-column">
                                    <span class="font-weight-normal">
                                        <i class="{{ $subItem['icon'] ?? '' }}  pr-1"></i>
                                        {{ $subItem['title'] }}
                                    </span>
                                    <small class="font-weight-light">{{ $subItem['description'] ?? '' }}</small>
                                </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</nav>
