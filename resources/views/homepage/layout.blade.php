<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>T.F.V. 'Professor Francken'</title>


        @if (request()->exists('red'))
            <link rel="stylesheet" href="{{ mix('/dist/css/red.css') }}">
        @elseif (request()->exists('slef'))
            <link rel="stylesheet" href="{{ mix('/dist/css/slef.css') }}">
        @else
            <link rel="stylesheet" href="{{ mix('/dist/css/app.css') }}">
        @endif

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

        @include('homepage.favicon')
    </head>
    <body>
        @yield('content')
    </body>
</html>
