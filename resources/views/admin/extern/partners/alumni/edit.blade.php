@extends('admin.extern.partners.sponsor-options.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Edit ' . $alumnus->fullname)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($alumnus, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminPartnerAlumniController::class, 'update'],
                               ['partner' => $partner, 'alumnus' => $alumnus]
                           ),
                           'method' => 'PUT',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.extern.partners.alumni._form', ['partner' => $partner, 'alumnus' => $alumnus])

                        {!! Form::submit('Save alumnus', ['class' => 'btn btn-outline-success']) !!}
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
                   [\Francken\Extern\Http\AdminPartnerAlumniController::class, 'destroy'],
                   ['partner' => $partner, 'alumnus' => $alumnus]
               ),
               'method' => 'post'
           ]
       )
    !!}
    @method('DELETE')
    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this alumnus?");'
              >here</button> to remove this alumnus.

    </p>
    {!! Form::close() !!}
@endsection
