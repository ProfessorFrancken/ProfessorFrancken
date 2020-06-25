@extends('admin.layout')
@section('page-title', 'Partners / ' . $partner->name)

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
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
                        <div>
                            <img
                                class="rounded mr-3"
                                src="{{ $partner->logo }}"
                                alt="Logo of {{ $partner->name }}"
                                style="max-height: 90px;"
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-body">
                    <h4 class="font-weight-bold">Sponsor options</h4>

                    <p>
                        Below varous sponsor options are listed that you can enable for a partner.
                    </p>
                </div>

                <ul class="list-unstyled mt-3 mb-0">
                    <li class="p-3 pb-4 border-top bg-white">
                        @include('admin.extern.partners._company-profile', ['partner' => $partner])
                    </li>
                    <li class="p-3 pb-4 border-top bg-white">
                        @include('admin.extern.partners._footer', ['partner' => $partner])
                    </li>
                    <li class="p-3 pb-4 border-top bg-light">
                        @include('admin.extern.partners._vacancies', ['partner' => $partner])
                    </li>
                    <li class="p-3 pb-4 border-top d-none bg-light">
                        <h5 class="h6 font-weight-bold">
                            Streepsysteem sponsor
                        </h5>

                        <p>
                            This partner's logo is not shown in the streepsysteem
                        </p>
                    </li>
                    <li class="p-3 pb-4 border-top d-none bg-light">
                        <h5 class="h6 font-weight-bold">
                            TV sponsor
                        </h5>

                        <p>
                            This partner's logo is not shown on our tv
                        </p>
                    </li>
                </ul>
            </div>

            {!!
               Form::model(
                   $partner,
                   [
                       'url' => action(
                           [\Francken\Extern\Http\AdminPartnersController::class, 'destroy'],
                           ['partner' => $partner]
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

                    <ul class='list-unstyled'>

                        @forelse ($partner->notes as $note)
                            <li class="d-flex flex-column {{ $loop->last ? '' : 'border-bottom  my-3 py-3' }}">
                                <small class="text-muted">
                                    On {{ $note->created_at->format('Y-m-d') }}, {{ $note->member->fullname }} wrote:
                                </small>
                                <p class="bg-light p-3 my-1">
                                    {{ $note->note }}
                                </p>
                            </li>
                        @empty
                            <li class="d-flex flex-column my-3">
                                Use these notes to keep to keep track of arrangements with a partner or any other information that might be useful for you or your future kandi.
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer">
                    {!!
                       Form::model($partner, [
                           'url' => action(
                               [\Francken\Extern\Http\AdminPartnerNotesController::class, 'store'],
                               ['partner' => $partner]
                           ),
                           'method' => 'POST',
                       ])
                    !!}
                    <div class="form-group">
                        {!!
                           Form::textarea(
                               'note',
                               null,
                               ['class' => 'form-control', 'id' => 'note', 'rows' => 3]
                           )
                        !!}
                    </div>
                    <button class='btn btn-text'>
                        <i class="fas fa-check"></i>
                        Save note
                    </button>
                    {!! Form::close() !!}
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
        <a href="{{ action([\Francken\Extern\Http\AdminPartnersController::class, 'edit'], ['partner' => $partner]) }}"
           class="btn btn-primary"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>
    </div>
@endsection