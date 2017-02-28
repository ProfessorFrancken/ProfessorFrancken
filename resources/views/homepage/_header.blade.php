<header class="header">
    <div class="container-fluid">
        <div class="row">
            {{-- Note: we add a padding left 0 since the gutter from the row adds a padding --}}
            <div class="col-12 col-md-4 col-lg-5 pl-0 pr-0">
                @include("homepage._logo")
            </div>
            <div class="col col-sm-4 col-md-8 col-lg-7 hidden-sm-down ">
                @include("homepage.navigation._navigation")
            </div>
        </div>
    </div>

    @yield('header-image')
</header>
