<div
    class="header__logo h-100 flex-grow-1 flex-md-grow-0 skew-md--top-right bg-primary d-flex flex-md-column justify-content-end justify-content-md-end"
    style="box-shadow: 0 0px 5px rgba(0,0,0,0.2); box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.8);"
>
    <a class="header__title-link justify-content-begin justify-content-md-end align-items-center d-inline-flex" href="/">
        @svg('LOGO_KAAL', 'svg-logo scaleUp--hover', ['height' => '100px'])

        <span class="d-md-none header__title text-center">
            T.F.V.<br class="d-none d-md-inline"/>
            'Professor<br class="d-none d-md-inline"/>
            Francken'
        </span>
    </a>

    @include('layout.navigation._hamburger')

    {{--

        This section contains all of the menu items
        We're using partial views so we can focus on
        the structure on the menu

    --}}
    <ul class="navigation-list clearfix" id="main-menu">
        @foreach ($items as $item)
            @include('layout.navigation._mobile-navigation-item', [
                'url' => $item['url'],
                'title' => $item['title'],
                'icon' => $item['icon'],
                'subItems' => $item['subItems'],
            ])
        @endforeach
    </ul>
</div>
