@extends('admin.layout')

@section('content')
    <h1 class="section-header">
        Francken Vrij
    </h1>

    <div class="row">
        <div class="col-lg-4 flex-lg-last">
            @include('admin.francken-vrij._create')
        </div>

        <div class="col-lg-8">
            <div class="card my-3">
                <div class="card-block">

                    <h4>Our collection</h4>

                    @foreach ($volumes as $volume)
                        <div class="row">
                            @foreach ($volume->editions() as $edition)
                                <div class="col-sm-4">
                                    <h5>
                                        {{ $edition->title() }}

                                        <span class="text-right pull-right">
                                            <small>
                                                <a href="/admin/association/francken-vrij/{{ $edition->getId() }}">
                                                    <i class="fa fa-pencil mr-1" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ $edition->pdf() }}">
                                                    <i class="fa fa-download mr-1" aria-hidden="true"></i>
                                                </a>
                                            </small>
                                        </span>
                                    </h5>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
