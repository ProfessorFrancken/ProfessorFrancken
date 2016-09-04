@extends('base-layout')


@section('internal-content')
    @include('layout._header')

    <!-- <img style="width: 100%" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/11/das_header-1080x400.png"> -->

    <div class="container-fluid">
        @yield('content')
    </div>

    @include('_about')
@endsection
