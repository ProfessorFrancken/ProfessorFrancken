@extends('homepage.one-column-layout')

@section('header-image-url', '/images/header/oslo.jpg')
@section('title', "404 - Page not found - T.F.V. 'Professor Francken'")

@section('header-image')
@endsection

@section('content')
    <h1 class="section-header section-header--centered">
        Page not found
    </h1>

    <div class="row">
        <div class="col-md-12 text-center">
            <canvas id='mpcCanvas' width="1600px" height="680px" style="
                        background-color: #fafafa;

                        border: thin solid #fefefe;
                        width: 100%;
                        border-radius: 25%;


                        ">
            </canvas>
        </div>
    </div>

    <script src="/js/404.js"></script>
@endsection
