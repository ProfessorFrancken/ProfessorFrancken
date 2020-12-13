<!doctype html>
<html lang="en" class="h-100">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        @include('layout._seo')

        @unless(config('env') == 'testing')
            <link rel="stylesheet" href="{{ mix('/dist/css/app.css') }}">
        @endunless

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.css" integrity="sha384-wITovz90syo1dJWVh32uuETPVEtGigN07tkttEqPv+uR2SE/mbQcG7ATL28aI9H0" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js" integrity="sha384-/y1Nn9+QQAipbNQWU65krzJralCnuOasHncUFXGkdwntGeSvQicrYkiUBwsgUqc1" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/contrib/auto-render.min.js" integrity="sha384-dq1/gEHSxPZQ7DdrM82ID4YVol9BYyU7GbWlIwnwyPzotpoc57wDw/guX8EaYGPx" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

        @stack('styles')

        @include('layout._favicon')
    </head>
    <body class="h-100">
        <main class="d-flex flex-column justify-content-between h-100">
            <div>
                @include('layout._header')
                @yield('main-content')
            </div>
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
        </script>

        @stack('scripts')
    </body>
</html>
