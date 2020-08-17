@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Add vacancy')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!!
                       Form::model($vacancy, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminVacanciesController::class, 'store'],
                               ['partner' => $partner]
                           ),
                           'method' => 'POST',
                       ])
                    !!}
                        @include('admin.extern.partners.sponsor-options.vacancies._form', ['partner' => $partner, 'vacancy' => $vacancy])

                        <x-forms.submit>Add vacancy</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
