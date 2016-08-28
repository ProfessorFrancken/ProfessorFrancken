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

  <body id="page-top" data-spy="scroll" data-ta rget=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="padding-bottom: 0px">
      <div id="main-menu" class="container" style="padding-bottom: 15px">

        <a style="padding: 0px" class="navbar-brand page-scroll" href="/">
          <img style="height: 100%" src="/images/LOGO_KAAL.png">
        </a>

        <div class="navbar-header page-scroll">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
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
      <div id="sub-menu" style="background-color: #483A78; text-align: center">
        <ul class="nav navbar-nav navbar-center" style="float: none; display: inline-block; font-size: smaller">
          <li><a href="#history" style="padding: 10px 30px;">History</a></li>
          <li><a href="#boards" style="padding: 10px 30px;">Boards</a></li>
          <li><a href="#committees" style="padding: 10px 30px;">Committees</a></li>
        </ul>
      </div>
    </nav>

    <div class="container">
      @yield('content')
    </div>


    <!-- FOOTER -->
    <footer class="footer">
      <div class="footerinfo">
        <div class="container">
          <div class="col-sm-4">
            <h3>Adress</h3>
            <address>
              Nijenborgh 4<br>
              9747AG, Groningen<br>
              The Netherlands
            </address>
          </div>
          <div class="col-sm-4">
            <h3>Quick links</h3>
            mail: <a href="malto: board@professorfrancken.nl">board@professorfrancken.nl</a> <br>
            tel: +31 (0) 50 363 4978 <br>
            Kvk: 400 252 71

          </div>
          <div class="col-sm-4">
            <h3>Social media</h3>
            Facebook <br>
            Twitter <br>
            Github
          </div>
        </div>
      </div>

      <div class="sponsors">
        <div class="container-fluid">
          <!-- <h3>Sponsors</h3> -->
          <ul class="list-inline">
            <li>
              <img alt="" src="http://www.professorfrancken.nl/wordpress/media/images/frontpagelogos/asml.png"/>
            </li>
            <li>
              <img alt="" src="http://www.professorfrancken.nl/wordpress/media/images/frontpagelogos/TMC.png"/>
            </li>
            <li>
              <img alt="" src="http://www.professorfrancken.nl/wordpress/media/images/frontpagelogos/thales.png"/>
            </li>
            <li>
              <img alt="" src="http://www.professorfrancken.nl/wordpress/media/images/frontpagelogos/shell.png"/>
            </li>
            <li>
              <img alt="" src="http://www.professorfrancken.nl/wordpress/media/images/frontpagelogos/Schut.png"/>
            </li>
            <li>
              <img alt="" src="http://www.professorfrancken.nl/wordpress/media/images/frontpagelogos/optiver.png"/>
            </li>
            <li>
              <img alt="" src="http://www.professorfrancken.nl/wordpress/media/images/frontpagelogos/ZIAM.png"/>
            </li>
          </ul>
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
