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
                @include('layout._navigation-top-menu-item', [
                    'url' => '/about',
                    'title' => 'About',
                    'subItems' => [
                        ['url' => "/about/history", 'title' => 'History'],
                        ['url' => "/about/honorary-members", 'title' => 'Honerary members'],
                        ['url' => "/about/boards", 'title' => 'Boards'],
                        ['url' => "/about/committees", 'title' => 'Committees'],
                        ['url' => "/about/francken-vrij", 'title' => 'Francken Vrij']
                    ]
                ])
                @include('layout._navigation-top-menu-item', [
                    'url' => '/news',
                    'title' => 'News',
                    'subItems' => [
                        ['url' => "/post", 'title' => 'All'],
                        ['url' => "/news", 'title' => 'News'],
                        ['url' => "/blog", 'title' => 'Blog']
                    ]
                ])
                @include('layout._navigation-top-menu-item', ['url' => '/study', 'title' => 'Study'])
                @include('layout._navigation-top-menu-item', [
                    'url' => '/career',
                    'title' => 'Career',
                    'subItems' => [
                        ['url' => "/career/job-openings", 'title' => 'Job openings'],
                        ['url' => "/career/companies", 'title' => 'Company profiles'],
                        ['url' => "/career/excursions", 'title' => 'Excursions']
                    ]
                ])
                @include('layout._navigation-top-menu-item', ['url' => '/books', 'title' => 'Books'])
                @include('layout._navigation-top-menu-item', ['url' => 'https://www.flickr.com/photos/fotocie/sets/', 'title' => 'Photos'])
                @include('layout._navigation-top-menu-item', ['url' => '/contact', 'title' => 'Contact'])
            </ul>
        </nav>
    </header>
</div>
