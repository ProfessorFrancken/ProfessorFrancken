<html lang="en">
    @include('layout._head')

    <body id="page-top" data-spy="scroll" data-ta rget=".navbar-fixed-top">
        @include('layout._navigation')

        @section('internal-content')
            <div class="container">
                @yield('content')
            </div>
        @show

        @include('layout._footer')
        @include('layout._javascript')
    </body>
</html>
