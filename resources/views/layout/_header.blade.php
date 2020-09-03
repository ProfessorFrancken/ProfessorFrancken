<header class="header d-flex" style="z-index: 1">
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

        @include('layout.navigation._mobile-navigation')
    </div>

    <div
        class="d-none d-md-block flex-md-grow-1 bg-white navigation-container__wrapper h-100"
        style="
        box-shadow: 0 0px 5px rgba(0,0,0,0.2);
        z-index:1;"
    >
        <div class="container">
            @include("layout.navigation._navigation")
        </div>
    </div>
</header>

@include('layout._breadcrumbs')

@auth
<div class="container">
    <x-borrelcie-notifications />
    @stack('notifications')
</div>
@endauth
