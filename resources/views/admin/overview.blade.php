@extends('admin.layout')
@section('page-title', 'Hoi, ' . $board->board_name->toString())

@section('content')
    <div class="row">
        <div class="col">
            <p class="lead">
                Welcome to the administration page of T.F.V. 'Professor Francken'.
            </p>

            <p>
                This page is currently quite empty as I'm not sure what to put here yet.
                On the right you can find notifications as well as a short to do list of the website.
            </p>
        </div>
        <div class="col-3">
            <div class="card">
                <div class='card-body'>
                    <h4 class="h5 font-weight-bold">
                        Notifications
                    </h4>
                    <div>
                        <div class="bg-light mt-4 p-5 text-muted text-center">
                            <pan class="h6 text-muted">Nothing to see here</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card my-4">
                <div class='card-body'>
                    <h4 class="h5 font-weight-bold">
                        Website todo list
                    </h4>
                    <ul class="pl-4">
                        <li>Board notifications</li>
                        <li>Member login system</li>
                        <li>Managing members</li>
                        <li>Streepsysteem 2.0</li>
                        <li>Research groups</li>
                        <li>Sister & brother associations</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
