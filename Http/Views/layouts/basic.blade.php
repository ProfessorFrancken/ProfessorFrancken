<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>T.F.V. 'Professor Francken'</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/home.css" rel="stylesheet">
  </head>

  <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="/">
                  <img style="height: 1em" src="/images/LOGO_KAAL.png">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/about">About</a>
                    </li>
                    <li>
                        <a href="/news">News</a>
                    </li>
                    <li>
                        <a href="/study">Study</a>
                    </li>
                    <li>
                        <a href="/career">Carreer</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header -->
    <header style="background-image: url('http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/11/das_header-1080x400.png')">
      <div style="width:100%; height: 400px; color: white;">
              <h1 style="padding-top: 200px; text-align: center;  font-size: 50px">T.F.V. 'Professor Francken'</h1>
              <hr class="small">
      </div>
    </header>

    <!-- <img style="width: 100%" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/11/das_header-1080x400.png"> -->
    

    <div class="container">
      @yield('content')
    </div>


    <!-- FOOTER -->
    <footer class="footer">
      <div class="container">
        <div class="col-sm-4">
          <address>
            <strong>T.F.V. Professor Francken</strong><br>
            Nijenborgh 4<br>
            9747AG, Groningen<br> 
            The Netherlands
          </address>
        </div>
        <div class="col-sm-4">
          <strong>Quick links</strong><br>
          <a href="#">contact</a><br>
          <a href="#">contact</a><br>
          <a href="#">contact</a>
        </div>
        <div class="col-sm-4">
          <strong>Sponsors</strong><br>
          plaatje<br>
          plaatje
        </div>
      </div>
    </footer>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <script src="js/home.js"></script>
  

  </body>
</html>
