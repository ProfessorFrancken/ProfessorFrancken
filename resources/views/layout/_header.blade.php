<header
    class="d-flex justify-content-between bg-primary"
    style="height: 100px; box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25); background: #8cd3cb; background: black; "
>
    {{-- Note: we add a padding left 0 since the gutter from the row adds a padding --}}
    @include("layout._logo")

    <div class="container d-flex align-items-center">
    @include("layout.navigation._navigation")
   </div>



</header>

@yield('header-image')
