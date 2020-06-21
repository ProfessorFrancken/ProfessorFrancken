<!doctype html>
<html lang="en" class="h-100">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        @include('layout._seo')
        @include('layout._favicon')

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        @unless(config('env') == 'testing')
            <link rel="stylesheet" href="{{ mix('/dist/css/print.css') }}">
        @endunless
    </head>
    <body class="h-100">
        <div class="styled-layout francken-layout">
            <div class="styled-header francken-header">
                <div class="styled_header__logo text-white bg-primary">
                    <a class="d-inline-flex flex-column text-center">
                        @svg('LOGO_KAAL', 'svg-logo scaleUp--hover', ['height' => '120px'])
                    </a>
                </div>
            </div>
            <div class="styled-navigation francken-navigation text-left d-flex justify-content-between align-items-center ml-3 mt-4">
                <h1 class="ml-4 mb-0 h2">
                    T.F.V. 'Professor Francken'
                </h1>

                @section('corner')
                @show
            </div>
            <main class="francken-content">
                @yield('content')
            </main>
            <footer class="francken-footer">
                @section('footer')
                @show
            </footer>
        </div>
        @include('admin._scripts')
    </body>
</html>
