<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>T.F.V. 'Professor Francken'</title>


        @unless(env('APP_ENV') == 'testing')
            @if (request()->exists('red'))
                <link rel="stylesheet" href="{{ mix('/dist/css/red.css') }}">
            @elseif (request()->exists('slef'))
                <link rel="stylesheet" href="{{ mix('/dist/css/slef.css') }}">
            @else
                <link rel="stylesheet" href="{{ mix('/dist/css/app.css') }}">
            @endif
        @endunless

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

        @include('homepage._favicon')
    </head>
    <body>
        <header class="header">
            <div class="row">
                <div class="col-7 col-md-5 col-sm-8 text-right">
                    @include("homepage._logo")
                </div>
                <div class="col-5 col-md-7 col-sm-4">
                    @include("homepage.navigation._navigation")
                </div>
            </div>

            @yield('header-image')
        </header>

        @yield('main-content')

        @include("homepage._footer")
    </body>
</html>
