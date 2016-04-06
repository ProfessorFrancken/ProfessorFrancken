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

  <!-- NAVBAR -->
  <body>
    <div class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">T.F.V.</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <!--<li class="active"><a href="#">Home</a></li> I think we can leave this out, since we already have the navbar brand button-->
                <li><a href="/news">News</a></li>
                <li><a href="/study">Study</a></li>
                <li><a href="/career">Career</a></li>
                <li class="dropdown">
                  <a href="#association" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"  aria-expanded="false">Association <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="#board">Board</a></li>
                      <li><a href="#comittees">Committees</a></li>
                    </ul>
                  </li>
			</ul>	  
			<ul class="nav navbar-nav navbar-right">
                <li><a href="#contact">Contact</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>

    <div class="container">
      @yield('content')
    </div><!-- .container -->

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
    <script src="../bootstrap/js/bootstrap.min.js"></script>
  

  </body>
</html>


