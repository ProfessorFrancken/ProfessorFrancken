@extends('layout.two-column-layout')

@section('aside')
    @include('profile._sidebar')
@endsection

@section('header-image')
    @component('layout.header._header_image')
    <div class="header-image__title">

    </div>
    @endcomponent
@endsection
