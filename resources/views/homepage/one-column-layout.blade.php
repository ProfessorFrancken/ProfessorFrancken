@extends('homepage.layout')

@section('main-content')
    <div class="container my-4">
        @yield('content')
    </div>
@endsection

@section('header-image')
    @component('layout.header._header_image')
    @slot('headerImageClass')
        header__registration-cta--small
    @endslot

    @endcomponent
@endsection
