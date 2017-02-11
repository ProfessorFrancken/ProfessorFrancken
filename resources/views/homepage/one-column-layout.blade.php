@extends('homepage.layout')

@section('main-content')
    <div class="container">
        @yield('content')
    </div>
@endsection

@section('header-image')
    @component('homepage.header._header_image')
    @slot('headerImageClass')
        header__registration-cta--small
    @endslot

    @endcomponent
@endsection
