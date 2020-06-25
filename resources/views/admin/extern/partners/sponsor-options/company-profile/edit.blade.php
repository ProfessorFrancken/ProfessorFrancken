@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Edit company profile')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($profile, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminCompanyProfilesController::class, 'update'],
                               ['partner' => $partner]
                           ),
                           'method' => 'PUT',
                       ])
                    !!}
                        @include('admin.extern.partners.sponsor-options.company-profile._form', ['partner' => $partner])

                        {!! Form::submit('Save company profile', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
