<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="padding-bottom: 0px">
    <div id="main-menu" class="container">

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
                <li>
                    <a href="/books">Books</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
    <div id="sub-menu" class="container-fluid">
        @yield('sub-menu')
    </div>
</nav>
