@extends('admin.layout')
@section('page-title', 'Partners / ' . $partner->name . ' / Add company profile')

@section('actions')
    <div class="d-flex align-items-end">
        <a
            class="btn btn-primary"
            href="{{ action(
                     [\Francken\Extern\Http\AdminPartnersController::class, 'show'],
                     ['partner' => $partner]
                     ) }}"
        >
            Back
        </a>
    </div>
@endsection
