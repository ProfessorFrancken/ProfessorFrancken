<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        @include('homepage._seo')

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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.css" integrity="sha384-wITovz90syo1dJWVh32uuETPVEtGigN07tkttEqPv+uR2SE/mbQcG7ATL28aI9H0" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js" integrity="sha384-/y1Nn9+QQAipbNQWU65krzJralCnuOasHncUFXGkdwntGeSvQicrYkiUBwsgUqc1" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/contrib/auto-render.min.js" integrity="sha384-dq1/gEHSxPZQ7DdrM82ID4YVol9BYyU7GbWlIwnwyPzotpoc57wDw/guX8EaYGPx" crossorigin="anonymous"></script>


        @include('homepage._favicon')
    </head>
    <body>
        <main>
            @include('homepage._header')

            @yield('main-content')

            @include("homepage._footer")
        </main>

        @include('homepage.components._modal')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"> </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/js/LoginModal.js"></script>
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
  <script>

   document.addEventListener("DOMContentLoaded", function() {
      renderMathInElement(document.body);
   });
  </script>
    </body>
</html>

@section('description')
‘Professor Francken’ is the study association for Applied Physics, connected to the University of Groningen. It is named after Groningen’s first professor of Applied Physics and is for students and staff of the applied physics departments. It has over 700 members and organizes, among other, field trips in the Netherlands and an annual symposium and a foreign excursion. Various activities, including the introductory activities for first-year students and the Bèta-bedrijvendagen (a career event for science students), are organised in partnership with sister associations. Membership is a must for students with a technical orientation.
@endsection
