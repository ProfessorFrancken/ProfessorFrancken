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
        <div class="row no-gutters h-100 order-2">
            <div class="col-12 col-lg-2 col-md-3 bg-primary order-2 order-md-0 d-print-none">
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
                                        @if ($subItem['works'] || Auth::user()->can('super-admin-read'))
                                            <li class="{{ $active }} text-white">
                                                <a  href="/admin/{{ $item['url'] }}/{{ $subItem['url'] }}" class="d-block px-3 py-2 admin-navigation-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        @if (! $subItem['works'])
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        @endif

                                                        {{ $subItem['name'] }}
                                                    </span>

                                                    <span class="badge badge-light d-none">3</span>
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
            <main class="col bd-content order-1">
                @isset ($breadcrumbs)
                <nav aria-label="breadcrumb" class="d-print-none d-flex justify-content-between bg-white rounded-0">
                    <ol class="breadcrumb bg-white py-4 mb-0" style="">
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if (! $loop->last)
                                <li class="breadcrumb-item">
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['text'] }}</a>
                                </li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $breadcrumb['text'] }}
                                </li>
                            @endif
                        @endforeach
                    </ol>

                    <div class="breadcrumb-item">
                        <a href="/" class="h-100 d-flex align-items-center px-4 text-muted">
                            Back to Francken
                        </a>
                    </div>
                </nav>
                @endisset
                <div class="p-4 pt-2">
                    <div class="d-flex justify-content-between align-itmes-center mb-4">
                        <h1 class="section-header">
                            @yield('page-title', 'Administration panel')
                        </h1>

                        @section('actions')
                        @show
                    </div>


                    @section('alerts')
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h3 class='h5'>We've found some validation errors while processing your request</h3>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <p>
                                    <strong>Note</strong>: I'm sorry for the crappy user feedback.
                                </p>
                            </div>
                        @endif
                    @show


                    @yield('content')
                </div>
            </main>
        </div>

        @include('admin._scripts')
    </body>
</html>
