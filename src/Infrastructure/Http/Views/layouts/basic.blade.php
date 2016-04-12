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
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-11 col-sm-offset-1">

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

            </div>
          </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header -->
    <!-- background-image: url('http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/11/das_header-1080x400.png') -->
    <header style="background-color: #31255E; ">
      <div style="width:100%; height: 400px; color: white;">
              <h1 style="padding-top: 200px; text-align: center;  font-size: 50px">T.F.V. 'Professor Francken'</h1>
              <hr class="small">
      </div>
    </header>

    <!-- <img style="width: 100%" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/11/das_header-1080x400.png"> -->

    <div class="container-fluid">
      @yield('content')
    </div>

    <div class="about-francken container-fluid">
      <div class="row">
        <div class="association col-sm-3 col-sm-offset-1">
          <h3>Association</h3>
          <p>
          Vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat! Id diam maecenas ultricies mi?
          </p>
        </div>
        <div class="study col-sm-3">
          <h3>Study</h3>
          <p>
            Nulla facilisi cras fermentum, odio eu feugiat pretium, nibh ipsum consequat nisl, vel pretium lectus quam id leo in vitae turpis massa sed elementum tempus. Massa placerat duis ultricies lacus.
          </p>

        </div>
        <div class="carreer col-sm-3">
          <h3>Carreer</h3>
          <p>
            Aliquam, purus sit amet luctus venenatis, lectus magna fringilla urna, porttitor rhoncus dolor purus non enim praesent elementum facilisis leo, vel fringilla est? Ornare massa, eget egestas purus viverra accumsan.
          </p>
        </div>
      </div>
    </div>


    <!-- FOOTER -->
    <footer class="footer">
      <div class="container-fluid">
        <div class="col-sm-3 col-sm-offset-1">
          <h5>T.F.V. Professor Francken</h5>
          <address>
            Nijenborgh 4<br>
            9747AG, Groningen<br>
            The Netherlands
          </address>
        </div>
        <div class="col-sm-3">
          <h5>Quick links</h5>
          <a href="#">contact</a><br>
          <a href="#">contact</a><br>
          <a href="#">contact</a>
        </div>
        <div class="col-sm-3">
          <h5>Sponsors</h5>
          plaatje<br>
          plaatje
        </div>
      </div>
    </footer>

    <div class="sponsors">
      <div class="container-fluid ">
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


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <script src="js/home.js"></script>


  </body>
</html>
