@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Add contact')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($contact, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminPartnerContactsController::class, 'store'],
                               ['partner' => $partner]
                           ),
                           'method' => 'POST',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.extern.partners.contacts._form', ['partner' => $partner, 'contact' => $contact])

                        <x-forms.submit>Add contact</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
