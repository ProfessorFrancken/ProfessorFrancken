@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Add alumnus')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($alumnus, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminPartnerAlumniController::class, 'store'],
                               ['partner' => $partner]
                           ),
                           'method' => 'POST',
                       ])
                    !!}
                        @include('admin.extern.partners.alumni._form', ['partner' => $partner, 'alumnus' => $alumnus])

                        <x-forms.submit>Add alumnus</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
