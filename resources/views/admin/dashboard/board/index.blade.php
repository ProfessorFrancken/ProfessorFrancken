@extends('admin.layout')
@section('page-title', 'Hoi, ' . $board->board_name->toString())

@section('content')
    <div class="row">
        <div class="col">
            <p class="lead">
                Welcome to the adtministration page of T.F.V. 'Professor Francken'.
            </p>

            <p>
                This page is currently quite empty as I'm not sure what to put here yet.
                On the right you can find notifications as well as a short to do list of the website.
            </p>
        </div>
        <div class="col-4">
            <div class="card">
                <div class='card-body'>
                    <h4 class="h5 font-weight-bold d-flex justify-content-start">
                        <span class="mr-1 badge badge-primary text-white">
                            {{ $total_notifications }}
                        </span>
                        Notifications
                    </h4>
                    <div>
                        @if ($notifications->isEmpty())
                            <div class="bg-light mt-4 p-5 text-muted text-center">
                                <span class="h6 text-muted">
                                    Nothing to see here
                                </span>
                            </div>
                        @else
                            <ul class="mt-4 text-muted list-unstyled">
                                @foreach ($notifications as $notification)
                                    <li class="bg-light p-3 my-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="h6 d-flex flex-column">
                                                <span class='mb-1'>
                                                    {{ $notification->data['headline'] ?? '' }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </h5>
                                            <div class="d-flex align-items-start">
                                                {!!
                                                       Form::model(
                                                           $notification,
                                                           [
                                                               'url' => action(
                                                                   [\Francken\Shared\Http\Controllers\BoardNotificationsController::class, 'destroy'],
                                                                   ['notification' => $notification]
                                                               ),
                                                               'method' => 'post'
                                                           ]
                                                       )
                                                !!}
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-text p-0  m-0 rounded">
                                                    <i class="far fa-check-circle"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>

                                        <p style="font-size: 0.8rem; line-height: 2.3" class="mb-0">
                                            From
                                            <span class="bg-white p-1 my-1">
                                            {{ $notification->data['from'] ?? '' }}
                                            </span>
                                            to
                                            <span class="bg-white p-1 my-1">
                                            {{ $notification->data['to'] ?? '' }}
                                            </span>.
                                        </p>
                                    </li>
                                @endforeach
                                <li class="my-3">
                                    {{ $notifications->links() }}
                                </li>
                            </ul>
                        @endif
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
