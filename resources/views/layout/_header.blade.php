<header class="header">
    <div class="container-fluid">
        <div class="row">
            {{-- Note: we add a padding left 0 since the gutter from the row adds a padding --}}
            <div class="col-12 col-md-4 col-lg-3 pl-0 pr-0" style="z-index: 1">
                @include("layout._logo")
            </div>
            <div class="offset-md-4 col-md-7 col-lg-5 d-none d-md-block">
                @include("layout.navigation._navigation")
            </div>
        </div>
    </div>

    @yield('header-image')
</header>
