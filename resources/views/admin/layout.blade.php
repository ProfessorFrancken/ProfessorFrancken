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
    <body class=" admin-page">
        <div class="francken-layout">
                <div class="styled-header francken-header">
                    <div class="styled_header__logo text-white bg-primary">
                        <a class="d-inline-flex flex-column text-center">
                            @svg('LOGO_KAAL', 'svg-logo scaleUp--hover', ['height' => '120px'])
                        </a>
                    </div>
                </div>

                <nav class="styled-navigation francken-navigation bg-primary">
                    <ul class="list-unstyled w-100">
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


            <main class="francken-content">
                @isset ($breadcrumbs)
                <div class="francken-breadcrumbs ">
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
                            <a href="/" class=" d-flex align-items-center px-4 text-muted">
                                Back to Francken
                            </a>
                        </div>
                    </nav>
                </div>
                @endisset

                <div class="p-4 pt-2">
                    <div class="d-flex justify-content-between align-itmes-center mb-4">
                        <h1 class="section-header">
                            @yield('page-title', 'Administration panel')
                        </h1>

                        @section('actions')
                        @show
                    </div>

                    @if (session('status'))
                        <p class="alert alert-success mb-3">
                            {{ session('status') }}
                        </p>
                    @endif

                    @if (session('error'))
                        <p class="alert alert-danger mb-3">
                            <strong>Error: </strong> {{ session('error') }}
                        </p>
                    @endif


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
            <footer class="francken-footer">
                HOI
            </footer>
        </div>

        @include('admin._scripts')
    </body>
</html>
