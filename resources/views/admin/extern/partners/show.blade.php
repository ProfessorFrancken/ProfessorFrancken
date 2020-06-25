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

                    <p>
                        Below varous sponsor options are listed that you can enable for a partner.
                    </p>

                    <ul class="list-unstyled mt-3">
                        <li class="p-3 bg-light my-3">
                            <h5 class="h6 font-weight-bold">
                                @if ($partner->companyProfile && $partner->companyProfile->is_enabled)
                                    <i class="far fa-check-square"></i>
                                @else
                                    <i class="far fa-square"></i>
                                @endif
                                Company profile
                            </h5>
                            @if ($partner->companyProfile === null)
                                <p>
                                    This partner has no company profile
                                </p>

                                <a
                                    href="{{ action([\Francken\Extern\Http\AdminCompanyProfilesController::class, 'create'], ['partner' => $partner]) }}"
                                    class="btn btn-text btn-sm"
                                >
                                    <i class="fas fa-check"></i>
                                    Enable company profile
                                </a>
                            @else
                                <div class='p-3 bg-white mt-3'>
                                    <h5 class="h6">Content:</h5>
                                    {!!  $partner->companyProfile->compiled_content !!}
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <p class="mb-0 mt-3">
                                        <a
                                            href="{{ action([\Francken\Extern\Http\AdminCompanyProfilesController::class, 'edit'], ['partner' => $partner])}}"
                                            class="btn btn-text btn-sm px-0"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Edit company profile
                                        </a>
                                    </p>
                                    <p class="mb-0 text-muted">
                                        Last changed {{ $partner->companyProfile->updated_at->diffForHumans() }}
                                    </p>
                                </div>
                            @endif
                        </li>
                        <li class="p-3 bg-light my-3">
                            <h5 class="h6 font-weight-bold">
                                Footer sponsor
                            </h5>
                            <p>
                                This partner's logo is not shown in our footer
                            </p>
                            <button class="btn btn-text btn-sm">
                                <i class="fas fa-check"></i>
                                Enable footer logo
                            </button>
                        </li>
                        <li class="p-3 bg-light my-3">

                            <h5 class="h6 font-weight-bold">
                                Job opportunities
                            </h5>
                            <p>
                                This partner's has no job opportunities
                            </p>
                        </li>
                        <li class="p-3 bg-light my-3">
                            <h5 class="h6 font-weight-bold">
                                Streepsysteem sponsor
                            </h5>

                            <p>
                                This partner's logo is not shown in the streepsysteem
                            </p>
                        </li>
                        <li class="p-3 bg-light my-3">
                            <h5 class="h6 font-weight-bold">
                                TV sponsor
                            </h5>

                            <p>
                                This partner's logo is not shown on our tv
                            </p>
                        </li>
                    </ul>
                </div>
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
                        @foreach ($partner->notes as $note)
                            <li class="d-flex flex-column {{ $loop->last ? '' : 'border-bottom  my-3 py-3' }}">
                                <small class="text-muted">
                                    On {{ $note->created_at->format('Y-m-d') }}, {{ $note->member->fullname }} wrote:
                                </small>
                                <p class="bg-light p-3 my-1">
                                    {{ $note->note }}
                                </p>
                            </li>
                        @endforeach
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
