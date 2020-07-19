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
                <div class="styled-header francken-header shadow-sm">
                    <div class="styled_header__logo text-white bg-dark-primary">
                        <a class="d-inline-flex flex-column text-center">
                            @svg('LOGO_KAAL', 'svg-logo scaleUp--hover', ['height' => '120px'])
                        </a>
                    </div>
                </div>

                <x-admin-navigation />

                @isset ($breadcrumbs)
                <div class="francken-breadcrumbs-background bg-white">
                {{--
                     This empty space is used to make sure that the white
                     background of the breadcrumbs continue underneath the logo
                --}}
                </div>
                <div class="francken-breadcrumbs">
                    <nav aria-label="breadcrumb" class="d-print-none bg-white rounded-0 pl-4 pl-md-0 h-100 d-flex align-items-center">
                        <div class=" container-fluid d-flex justify-content-between">
                        <ol class="breadcrumb bg-white py-2 py-md-4 mb-0" style="">
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
                        </div>
                    </nav>
                </div>
                @endisset

            <main class="francken-content">

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
                <p className="text-muted">
                    Hoi
                </p>
            </footer>
        </div>

        @include('admin._scripts')
    </body>
</html>
