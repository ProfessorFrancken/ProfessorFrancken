@extends('admin.layout')
@section('page-title', 'Symposia / ' . $symposium->name . ' / Name tags')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>
                        Participants
                    </h3>

                    <ul class="list-unstyled d-flex">
                        @foreach ($participants as $participant)
                            <li class="bg-light p-3 m-3 w-25 d-flex justify-content-start">
                                <img
                                    src="{{ image(url('/images/symposia/in-a-materialistic-world.png'), ['width' => '100']) }}"
                                    class="img-fluid mr-4"
                                    style="width: 100px"
                                />
                                <div class="d-flex flex-column justify-content-between">
                                <h3 class="">
                                    {{ $participant->full_name }}
                                </h3>
                                    <h5 class="text-muted h6">
                                        In a Materialistic World
                                    </h5>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
