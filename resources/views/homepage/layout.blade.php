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
        @include('homepage._header')

        @yield('main-content')

        @include("homepage._footer")

        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"> </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/js/Menu.js"></script>

        <script type="text/javascript">
         window._urq = window._urq || [];
         _urq.push(['initSite', '42efd18f-c4ef-4ad5-a1d8-a430d3f8ef0f']);
         (function() {
             var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
             ur.src = ('https:' == document.location.protocol ? 'https://cdn.userreport.com/userreport.js' : 'http://cdn.userreport.com/userreport.js');
             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
         })();
</script>
    </body>
</html>
