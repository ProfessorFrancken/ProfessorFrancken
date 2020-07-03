@extends('admin.layout')
@section('page-title', 'Francken Vrij')

@section('content')
    <div class="row">
        <div class="col-lg-3 flex-lg-last">
            @include('admin.francken-vrij._create')
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">

                    <h4>Our collection</h4>

                    @foreach ($volumes as $volume)
                        <div class="row align-items-stretch d-flex">
                            @foreach ($volume->editions() as $edition)
                                <div class="col-sm-4">
                                    <div class="d-flex p-3 bg-light my-2 d-flex">
                                        <div class="mr-3">
                                            <a href="{{ $edition->pdf() }}">
                                                <img
                                                    src="{{ $edition->cover() }}"
                                                    class="img-responsive center-block"
                                                    style="
                                                         max-width: 100px;
                                                         max-height: 150px;
                                                         "
                                                >
                                            </a>
                                        </div>
                                        <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                            <h5>
                                                {{ $edition->title() }}<br/>
                                                <small class="text-muted">
                                                    {{ $edition->volume() }}.{{ $edition->edition() }}
                                                </small>
                                            </h5>
                                            <div class='d-flex justify-content-between'>
                                                <a
                                                    href="{{ $edition->pdf() }}"
                                                    class="text-"
                                                >
                                                    <i class="fa fa-download text-muted mr-1" aria-hidden="true"></i> Download
                                                </a>
                                                <a
                                                    href="{{ action([\Francken\Association\FranckenVrij\Http\AdminFranckenVrijController::class, 'edit'], ['edition' => $edition]) }}"
                                                    class="text-primary"
                                                >
                                                    <i class="fa fa-edit text-muted mr-1" aria-hidden="true"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Association\FranckenVrij\Http\FranckenVrijController::class, 'index']) }}"
           class="btn btn-primary btn-sm"
        >
            <i class="fas fa-eye"></i>
            View francken vrij page
        </a>
    </div>
@endsection
