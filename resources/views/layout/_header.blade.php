<header class="header d-flex" style="z-index: 1">
    @include("layout._logo")
    <div
        class="d-none flex-md-grow-1 d-md-block bg-white navigation-container__wrapper"
        style="
        box-shadow: 0 0px 5px rgba(0,0,0,0.2);
        z-index:1;"
    >
        <div class="container">
            @include("layout.navigation._navigation")
        </div>
    </div>
</header>
