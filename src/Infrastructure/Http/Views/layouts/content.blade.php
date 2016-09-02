<html lang="en">
    @include('layout.head')

    <body id="page-top" data-spy="scroll" data-ta rget=".navbar-fixed-top">
        @include('layout.navigation')

        <div class="container">
            @yield('content')
        </div>

        @include('layout.footer')
        @include('layout.javascript')
    </body>
</html>
