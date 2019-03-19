<!doctype html>
<html lang="en" class="h-100">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        @include('layout._seo')
        @include('layout._favicon')
        @include('admin._styles')
    </head>
    <body class="h-100">
        <div class="row no-gutters h-100">
            <div class="col-12 col-lg-2 col-md-3 bg-primary">
                <a class="p-3 d-flex align-items-center justify-content-start text-white" href="/admin" style="background-color: #0a1d2d !important">
                    <span class="font-weight-bold h3 text-white mb-0 pb-0 w-100">
                        Francken
                        Admin
                    </span>
                    @svg('LOGO_KAAL', 'svg-logo scaleUp--hover', ['height' => '50px'])
                </a>

                <nav>
                    <ul class="list-unstyled">
                        @foreach ($menu as $item)
                            <li class="pb-4">
                                <span class="d-block font-weight-bold text-white h5 mb-0 p-3" style="background-color: #0e283e !important">
                                    {{ $item['name'] }}
                                </span>

                                <ul class="list-unstyled">
                                    @foreach ($item['items'] as $subItem)
                                        <?php $active = Request::segment(3) == $subItem['url'] ? 'active' : ''; ?>
                                        @can($subItem['can'] ?? 'can-access-dashboard')
                                        @if ($subItem['works'])
                                            <li class="{{ $active }} text-white">
                                                <a  href="/admin/{{ $item['url'] }}/{{ $subItem['url'] }}" class="d-block px-3 py-2 admin-navigation-item">
                                                    @if (! $subItem['works'])
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    @endif

                                                    {{ $subItem['name'] }}
                                                </a>
                                            </li>
                                        @endif
                                        @endcan
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            <main class="col-12 col-lg-10 col-md-9 bd-content">
                <div class="p-4 pt-2">
                    <h1 class="section-header mb-4">
                        @yield('page-title', 'Administration panel')
                    </h1>

                    @yield('content')
                </div>
            </main>
        </div>

        @include('admin._scripts')
    </body>
</html>
