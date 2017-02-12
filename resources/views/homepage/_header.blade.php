<header class="header">
    <div class="container-fluid">
        <div class="row">
            {{-- Note: we add a padding left 0 since the gutter from the row adds a padding --}}
            <div class="col-7 col-md-5 col-sm-8 text-right pl-0">
                @include("homepage._logo")
            </div>
            <div class="col-5 col-md-7 col-sm-4">
                @include("homepage.navigation._navigation")
            </div>
        </div>
    </div>

    @yield('header-image')
</header>
