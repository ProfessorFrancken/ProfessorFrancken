@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Add company profile')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($profile, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminCompanyProfilesController::class, 'store'],
                               ['partner' => $partner]
                           ),
                           'method' => 'POST',
                       ])
                    !!}
                        @include('admin.extern.partners.sponsor-options.company-profile._form', ['partner' => $partner])

                        <x-forms.submit>Add company profile</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
