<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        @include('layout._seo')

        @unless(config('env') == 'testing')
            @if (request()->exists('red'))
                <link rel="stylesheet" href="{{ mix('/dist/css/red.css') }}">
            @elseif (request()->exists('slef'))
                <link rel="stylesheet" href="{{ mix('/dist/css/slef.css') }}">
            @else
                <link rel="stylesheet" href="{{ mix('/dist/css/app.css') }}">
            @endif
        @endunless

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.css" integrity="sha384-wITovz90syo1dJWVh32uuETPVEtGigN07tkttEqPv+uR2SE/mbQcG7ATL28aI9H0" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js" integrity="sha384-/y1Nn9+QQAipbNQWU65krzJralCnuOasHncUFXGkdwntGeSvQicrYkiUBwsgUqc1" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/contrib/auto-render.min.js" integrity="sha384-dq1/gEHSxPZQ7DdrM82ID4YVol9BYyU7GbWlIwnwyPzotpoc57wDw/guX8EaYGPx" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        @stack('styles')

        @include('layout._favicon')
    </head>
    <body>
        <main>
            @include('layout._header')

            @yield('main-content')

            @include("layout._footer")
        </main>

        @include('layout._login-modal')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"> </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        @if (Auth::guest())
        <script src="/js/LoginModal.js"></script>
        @endif

        <script src="/js/Menu.js"></script>

        <script type="text/javascript">
         // Render  any latex currently loaded in our dom
         document.addEventListener("DOMContentLoaded", function() {
             renderMathInElement(document.body, {
                     delimiters: [
                         {left: "$$", right: "$$", display: true},
                         {left: "$", right: "$", display: false},
                         {left: "\\[", right: "\\]", display: true},
                         {left: "\\(", right: "\\)", display: false}
                     ]
                 }
             );
         });

         @if (config('francken.general.google-analytics'))
         // Google Analytics
         (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
             (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
         })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

         ga('create', '{{ config('francken.general.google-analytics') }}', 'auto');
         ga('send', 'pageview');
         @endif
        </script>

        @stack('scripts')
    </body>
</html>
