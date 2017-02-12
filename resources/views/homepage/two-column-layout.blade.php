@extends('homepage.layout')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col">
                @yield('content')
            </div>
            <div class="col-md-5">
                @include("homepage._agenda")
            </div>
        </div>
    </div>
@endsection

@section('header-image')
    @component('homepage.header._header_image')
    @slot('headerImageClass')
        header__registration-cta--small
    @endslot

    @endcomponent
@endsection
