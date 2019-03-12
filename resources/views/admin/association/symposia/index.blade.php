@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <h1 class="section-header">
                        Symposia
                    </h1>

                    <p>

                    </p>

                    <a href="{{ action([\Francken\Association\Symposium\Http\AdminSymposiaController::class, 'create']) }}"
                       class="btn btn-primary"
                    >
                        Create
                    </a>

                </div>

                @include('admin.association.symposia._table', ['symposia' => $symposia])


                {!! $symposia->links() !!}
            </div>
        </div>
        <div class="col-lg-4">

        </div>
    </div>
@endsection
