@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Edit vacancy')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!!
                       Form::model($vacancy, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminVacanciesController::class, 'update'],
                               ['partner' => $partner, 'vacancy' => $vacancy]
                           ),
                           'method' => 'PUT',
                       ])
                    !!}
                        @include('admin.extern.partners.sponsor-options.vacancies._form', ['partner' => $partner, 'vacancy' => $vacancy])

                        {!! Form::submit('Save vacancy', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

            {!!
               Form::model(
                   $partner,
                   [
                       'url' => action(
                           [\Francken\Extern\Http\AdminVacanciesController::class, 'destroy'],
                           ['partner' => $partner, 'vacancy' => $vacancy]
                       ),
                       'method' => 'post'
                   ]
               )
            !!}
            @method('DELETE')
            <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
    Click <button
              class="btn btn-text px-1"
              onclick='return confirm("Are you sure you want to remove this vacancy?");'
          >here</button> to remove this vacancy.

    </p>
            {!! Form::close() !!}
@endsection
