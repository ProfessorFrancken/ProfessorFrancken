<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        @include('layout._seo')
        @include('layout._favicon')
        @include('admin._styles')
    </head>
    <body>
        <nav class="navbar navbar-toggleable-md navbar-inverse bg-primary">
            <div class="text-white font-weight-bold d-flex justify-content-end align-items-end">
                @svg('LOGO_KAAL', 'svg-logo scaleUp--hover', ['height' => '50px'])
            </div>
            <a class="navbar-brand text-white" href="/admin">Francken admin</a>
        </nav>

        <main>
            <div class="row">
                <div class="col-12 col-lg-2 col-md-3 bd-sidebar bg-white">

                    <nav class="bd-links" id="docsNavbarContent">
                        @foreach ($menu as $item)

                            <div class="bd-toc-item active">
                                <span class="bd-toc-link font-weight-bold">
                                    {{ $item['name'] }}
                                </span>

                                <ul class="nav bd-sidenav">
                                    @foreach ($item['items'] as $subItem)
                                        <?php $active = Request::segment(3) == $subItem['url'] ? 'active' : ''; ?>
                                        @can($subItem['can'] ?? 'can-access-dashboard')
                                        <li class="{{ $active }} text-white">
                                            <a  href="/admin/{{ $item['url'] }}/{{ $subItem['url'] }}">
                                                @if (! $subItem['works'])
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                @endif

                                                {{ $subItem['name'] }}
                                            </a>
                                        </li>
                                        @endcan
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </nav>
                </div>
                <div class="col-12 col-lg-10 col-md-9 bd-content pt-4">
                    @yield('content')
                </div>
            </div>
        </main>

        @include('admin._scripts')
    </body>
</html>
