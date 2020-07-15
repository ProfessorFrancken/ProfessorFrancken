<div class="navigation__hamburger-menu">
    <button id="navbar-toggler" class="hamburger-menu">
        <span class="hamburger-menu__line"></span>
        <span class="hamburger-menu__line"></span>
        <span class="hamburger-menu__line"></span>
    </button>
</div>

<ul class="navigation-list clearfix" id="main-menu">
    @foreach ($items as $item)
        @include('layout.navigation._mobile-navigation-item', [
            'url' => $item['url'],
            'title' => $item['title'],
            'icon' => $item['icon'],
            'subItems' => $item['subItems'],
            ])
    @endforeach
</ul>
