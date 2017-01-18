@extends('admin.layout')

@section('content')
    <h1 class="page-header">Francken Vrij</h1>

    <div class="row">
        <div class="col-sm-4">
            @include('admin.francken-vrij._create')
        </div>

        <div class="col-sm-8">
            <h4>Our collection</h4>
            @foreach ($volumes as $volume)
                <div class="row">
                    @foreach ($volume->editions() as $edition)
                        <div class="col-sm-4">
                            <h5>
                                {{ $edition->title() }}

                                <span class="text-right pull-right">
                                    <small>
                                        <a href="/admin/francken-vrij/{{ $edition->getId() }}">Edit</a> |
                                        <a href="{{ $edition->pdf() }}">Download</a>
                                    </small>
                                </span>
                            </h5>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
