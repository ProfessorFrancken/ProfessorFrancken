@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Edit ' . $contact->fullname)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($contact, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminPartnerContactsController::class, 'update'],
                               ['partner' => $partner, 'contact' => $contact]
                           ),
                           'method' => 'PUT',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.extern.partners.contacts._form', ['partner' => $partner, 'contact' => $contact])

                        <x-forms.submit>Save contact</x-forms.submit>
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
                   [\Francken\Extern\Http\AdminPartnerContactsController::class, 'destroy'],
                   ['partner' => $partner, 'contact' => $contact]
               ),
               'method' => 'post'
           ]
       )
    !!}
    @method('DELETE')
    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this contact?");'
              >here</button> to remove this contact.

    </p>
    {!! Form::close() !!}
@endsection
