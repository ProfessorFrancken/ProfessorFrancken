@extends('layout.one-column-layout')
@section('title', "Photos - T.F.V. 'Professor Francken'")

@section('content')
    @if (session('private-album-login') === false)
        <div class="alert alert-danger font-weight-bold" role="alert">
            The password you've submitted is wrong.
        </div>
    @endif

    <h1 class="section-header section-header--centered mb-5">
        Photos
    </h1>

    <div class="card bg-light">
        <div class="card-body">
            <h3 class="h5">Login to view photos</h3>
            <p>
                Fill in the <strong>album password</strong> below to view more albums.
                Don't know the password? Ask a board member.
            </p>
            @include('association.photos._login-form')
        </div>
    </div>;

@endsection
