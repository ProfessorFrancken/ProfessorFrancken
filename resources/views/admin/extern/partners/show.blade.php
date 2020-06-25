@extends('admin.layout')
@section('page-title', 'Partners / ' . $partner->name)

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-start">
                        <div>
                            <img
                                class="rounded mr-3"
                                src="{{ $partner->logo }}"
                                alt="Logo of {{ $partner->name }}"
                                style="width: 90px; height: 90px; object-fit: cover;"
                            >
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="font-weight-bold">
                                <i class="fas fa-building"></i>
                                {{ $partner->sector->name }}
                            </h6>
                            <p>
                                <a href="{{ $partner->homepage_url }}">
                                    <i class="fas fa-globe"></i>
                                    Website
                                </a>
                                <small>
                                    (<a class="text-muted" href="{{ $partner->referral_url }}">Referral</a>)
                                </small>
                            </p>
                            <h6 class="font-weight-bold">
                                <i class="fas fa-clock"></i>
                                Last updated:
                                <small>{{ $partner->updated_at->diffForHumans() }}</small>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <h4 class="font-weight-bold">Sponsor options</h4>

                    <ul class="list-unstyled mt-3">
                    </ul>
                </div>
            </div>

            {!!
               Form::model(
                   $partner,
                   [
                       'url' => action(
                           [\Francken\Extern\Http\AdminPartnersController::class, 'destroy'],
                           ['partner' => $partner->id]
                       ),
                       'method' => 'post'
                   ]
               )
            !!}
            @method('DELETE')
            <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
                Click <button
                          class="btn btn-text px-1"
                          onclick='return confirm("Are you sure you want to remove this partner?");'
                      >here</button> to remove this partner.
            </p>
            {!! Form::close() !!}
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold">
                        Extern notes
                    </h4>
                </div>
                <div class="card-footer">
                    <div class="form-group">
                        <textarea name="note" class="form-control"  id="" rows="3"></textarea>
                    </div>
                    <button class='btn btn-text'>
                        <i class="fas fa-check"></i>
                        Save note
                    </button>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-body">
                    <h4 class="font-weight-bold">
                        <i class="fas fa-users"></i>
                        Contacts
                    </h4>
                </div>

                <div class="card-footer">
                    <button class='btn btn-text'>
                        <i class="fas fa-plus"></i>
                        Add contact
                    </button>
                </div>
            </div>

            @if (1 == 2)
            <div class="card mt-5">
                <div class="card-body">
                    <h4 class="font-weight-bold">
                        Alumni
                    </h4>
                </div>

                <div class="card-footer">
                    <h4>
                        Add alumni
                    </h4>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection

@section('actions')
    <div class="d-flex align-items-end">
        <a href="{{ action([\Francken\Extern\Http\AdminPartnersController::class, 'edit'], ['partner' => $partner->id]) }}"
           class="btn btn-primary mx-3"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>

        <a href="{{ action([\Francken\Extern\Http\AdminPartnersController::class, 'create']) }}"
           class="btn btn-primary mx-3"
        >
            <i class="fas fa-plus"></i>
            Add job opportunity
        </a>
        <a href="{{ action([\Francken\Extern\Http\AdminPartnersController::class, 'create']) }}"
           class="btn btn-primary mx-3"
        >
            <i class="fas fa-plus"></i>
            Add contact
        </a>
    </div>
@endsection
