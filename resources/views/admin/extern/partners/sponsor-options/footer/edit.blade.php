@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Edit footer')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($footer, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminFootersController::class, 'update'],
                               ['partner' => $partner]
                           ),
                           'method' => 'PUT',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.extern.partners.sponsor-options.footer._form', ['partner' => $partner])

                        <x-forms.submit>Save footer</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
