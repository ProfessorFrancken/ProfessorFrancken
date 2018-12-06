<header class="header">
    <div class="d-flex" style="z-index: 1">
        <div
            style="width: 300px; z-index: 1"
            class="flex-grow-1 flex-md-grow-0"
        >
            @include("layout._logo")
        </div>
        <div
            class="d-none flex-md-grow-1 d-md-block"
            style="margin-left: -300px"
        >
            <div class="container">
                @include("layout.navigation._navigation")
            </div>
        </div>
    </div>
    @yield('header-image')
</header>;
