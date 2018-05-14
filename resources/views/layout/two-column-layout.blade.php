@extends('layout.layout')

@section('main-content')
    <div class="container my-4">
        <div class="row">
            <div class="col">
                @yield('content')
            </div>
            <div class="col-lg-5">
                <div class="agenda-wrapper">
                    @yield('aside')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('header-image')
    @component('layout.header._header_image')
    @endcomponent
@endsection
