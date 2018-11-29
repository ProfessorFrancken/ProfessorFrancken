<a class="bg-white arrow-right justify-content-end align-items-center d-inline-flex h-100" href="/">
    <style type="text/css">
        .svg-logo {
            /* filter: brightness(0) invert(1); height: 125px;" */
            height: 150px;
            fill: white;
        }

        .arrow-right {
            position: relative;
            padding-right: 0px;
            /* clip-path: polygon(0 0, 100% 0, 250px 50%, 100% 100%, 0 100%);
             */
        }
        .arrow-right:after {
            --border-height: 50px;
            position: absolute;
            content: '';
            left: 100%;

            width: 0;
            height: 0;
            border-top: var(--border-height) solid transparent;
            border-bottom: var(--border-height) solid transparent;
            border-left: var(--border-height) solid white;
        }
        .st0 { fill: #173249 !important; }
    </style>
    @svg('LOGO_KAAL', 'p-3 svg-logo scaleUp--hover h-100 bg-white')
</a>

@include('layout.navigation._hamburger')

{{--

    This section contains all of the menu items
    We're using partial views so we can focus on
    the structure on the menu

    --}}
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
