<div class="header-wrapper">
    <header class="top-header container">
        <nav class="nav-bar clearfix">
            <div class="nav-bar-extras">
                <button id="navbar-toggler" class="nav-toggle">
                    <span class="menu-icon-bar"></span>
                    <span class="menu-icon-bar"></span>
                    <span class="menu-icon-bar"></span>
                </button>
            </div>

            <h1 class="logo">
                <a class="logo-link i-gsv-top" href="/"><span>T.F.V. 'Professor Francken'</span></a>
            </h1>

            <ul class="nav-bar-links clearfix" id="main-menu">
                <li class="top-level-menuitem has-sub-menu clearfix">
                    <a class="top-level-link" href="/about">
                        About
                    </a>
                    <span aria-expanded="false" class="top-caret" role="button">&nbsp;<i class="menu-caret"></i>&nbsp;</span>
                    <ul class="sub-level-menu">
                        @foreach ([['url' => "/about/history", 'title' => 'History'], ['url' => "/about/honorary-members", 'title' => 'Honerary members'], ['url' => "/about/boards", 'title' => 'Boards'], ['url' => "/about/committees", 'title' => 'Committees'], ['url' => "/about/francken-vrij", 'title' => 'Francken Vrij']] as $item)
                            <li>
                                <a class="sub-level-link" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="top-level-menuitem clearfix">
                    <a class="top-level-link" href="/news">News</a>
                    <span aria-expanded="false" class="top-caret" role="button">&nbsp;<i class="menu-caret"></i>&nbsp;</span>
                    <ul class="sub-level-menu">
                        @foreach ([['url' => "/post", 'title' => 'All'], ['url' => "/news", 'title' => 'News'], ['url' => "/blog", 'title' => 'Blog'],] as $item)
                            <li>
                                <a class="sub-level-link" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="top-level-menuitem clearfix">
                    <a class="top-level-link" href="/study">Study</a>
                </li>
                <li class="top-level-menuitem clearfix">
                    <a class="top-level-link" href="/career">Career</a>
                    <span aria-expanded="false" class="top-caret" role="button">&nbsp;<i class="menu-caret"></i>&nbsp;</span>
                    <ul class="sub-level-menu">
                        @foreach ([['url' => "/career/job-openings", 'title' => 'Job openings'], ['url' => "/career/companies", 'title' => 'Company profiles'], ['url' => "/career/excursions", 'title' => 'Excursions'],] as $item)
                            <li>
                                <a class="sub-level-link" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="top-level-menuitem clearfix">
                    <a class="top-level-link" href="/books">books</a>
                </li>
                <li class="top-level-menuitem clearfix">
                    <a class="top-level-link" href="https://www.flickr.com/photos/fotocie/sets/">Photos</a>
                </li>
                <li class="top-level-menuitem clearfix">
                    <a class="top-level-link" href="/contact">Contact</a>
                </li>
            </ul>
        </nav>
    </header>
</div>


{{--
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
                <li>
                    <a href="https://www.flickr.com/photos/fotocie/sets/">Photos</a>
                </li>
                <li>
                    <a href="/contact">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
    <div class="sub-menu" class="container-fluid">
        @yield('sub-menu')
    </div>
</nav>
--}}

{{--
This was working
<header class="top-header container">
    <nav class="nav-bar clearfix">
        <div class="nav-bar-extras">
            <button id="navbar-toggler" class="nav-toggle">
                <span class="menu-icon-bar"></span>
                <span class="menu-icon-bar"></span>
                <span class="menu-icon-bar"></span>
            </button>
        </div>

        <h1 class="logo">
            <a class="logo-link i-gsv-top" href="/"><span>T.F.V. 'Professor Francken'</span></a>
        </h1>

        <ul class="nav-bar-links clearfix" id="main-menu">
            <li class="top-level-menuitem has-sub-menu clearfix">
                <a class="top-level-link" href="/about">
                    About
                </a>
                <span aria-expanded="false" class="top-caret" role="button">&nbsp;<i class="menu-caret"></i>&nbsp;</span>
                <ul class="sub-level-menu">
                    <li>
                        <a class="sub-level-link" href="/de-gsv">Over de GSV</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/de-gsv/geschiedenis">Geschiedenis</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/de-gsv/pijlers">Pijlers</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/de-gsv/senaten">Senaten</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/de-gsv/commissies">Commissies</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/de-gsv/contact">Contact</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/de-gsv/oud-leden">Oud-leden</a>
                    </li>
                </ul>
            </li>
            <li class="top-level-menuitem clearfix">
                <a class="top-level-link" href="/forum">Forum</a>
            </li>
            <li class="top-level-menuitem clearfix">
                <a class="top-level-link" href="/albums">Fotoalbum</a>
            </li>
            <li class="top-level-menuitem clearfix">
                <a class="top-level-link" href="/activiteiten">Activiteiten</a>
            </li>
            <li class="top-level-menuitem has-sub-menu clearfix">
                <a class="top-level-link" href="/word-lid">
                    Word lid!
                </a>
                <span aria-expanded="false" class="top-caret" role="button">&nbsp;<i class="menu-caret"></i>&nbsp;</span>
                <ul class="sub-level-menu">
                    <li>
                        <a class="sub-level-link" href="/word-lid">Lid worden?</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/word-lid/studie-en-vereniging">Studie
                            &amp; Vereniging</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/word-lid/veel-gestelde-vragen">Veelgestelde vragen</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/word-lid/inschrijven">Inschrijven</a>
                    </li>
                </ul>
            </li>
            <li class="top-level-menuitem has-sub-menu clearfix">
                <a class="top-level-link" data-mfp-src="#login-dialog" href="/inloggen" id="login-link" rel="nofollow">
                    Inloggen
                </a>
                <span aria-expanded="false" class="top-caret" role="button">&nbsp;<i class="menu-caret"></i>&nbsp;</span>
                <ul class="sub-level-menu">
                    <li>
                        <a class="sub-level-link" href="/registreer" rel="nofollow">Registreren</a>
                    </li>
                    <li>
                        <a class="sub-level-link" href="/inloggen" rel="nofollow">Inloggen</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>


--}}
