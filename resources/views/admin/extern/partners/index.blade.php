@extends('admin.layout')
@section('page-title', 'Partners')

@section('content')
    <div class="card">
        <div class="card-header p-0">
            <ul class="nav nav-tabs card-header-tabs m-0">
                @component('admin.extern.partners._tab-navigation', ['request' => $request, 'select' => 'all', 'class' => 'border-left-0'])
                    All partners
                    <span class="badge badge-secondary text-white">
                        {{ $all_partners }}
                    </span>
                @endcomponent
                @component('admin.extern.partners._tab-navigation', ['request' => $request, 'select' => 'active-contract'])
                    Active contract
                    <span class="badge badge-secondary text-white">
                        {{ $active_partners }}
                    </span>
                @endcomponent
                @component('admin.extern.partners._tab-navigation', ['request' => $request, 'select' => 'recently-expired-contract'])
                    Recently expired contract
                    <span class="badge badge-secondary text-white">
                        {{ $recently_expired_partners }}
                    </span>
                @endcomponent
                @component('admin.extern.partners._tab-navigation', ['request' => $request, 'select' => 'expired-contract'])
                    Expired contract
                    <span class="badge badge-secondary text-white">
                        {{ $expired_partners }}
                    </span>
                @endcomponent
                @component('admin.extern.partners._tab-navigation', ['request' => $request, 'select' => 'having-alumni'])
                    With alumni
                    <span class="badge badge-secondary text-white">
                        {{ $with_alumni_partners }}
                    </span>
                @endcomponent
            </ul>
        </div>

        <div class="card-body">
            <h4 class="font-weight-bold">
                Search
            </h4>
            <form action="{{ action([\Francken\Extern\Http\AdminPartnersController::class, 'index']) }}"
                  method="GET"
                  class="form"
            >
                <div class="d-flex mb-3">
                    <div class="form-group mr-2 mb-0">
                        <label for="name">Name</label>
                        {!! Form::text('name', $request->name(), ['placeholder' => 'Search by name', 'class' => 'form-control'])  !!}
                    </div>
                    <div class="form-group mx-2 mb-0">
                        <label for="sector_id">Sector</label>
                        {!! Form::select('sector_id', $sectors, $request->sectorId(), ['class' =>'form-control', 'id' => 'sector_id']) !!}
                    </div>
                    <div class="form-group mx-2 mb-0">
                        <label for="status">Partner status</label>
                        {!! Form::select('status', $statuses, $request->status(), ['class' =>'form-control', 'id' => 'status']) !!}
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <button type="submit" class="mx-2 btn btn-sm btn-primary">
                            <i class="fas fa-search"></i>
                            Apply filters
                        </button>
                        <a href="{{ action([\Francken\Extern\Http\AdminPartnersController::class, 'index'])  }}"
                           class="btn btn-sm btn-text text-primary"
                        >
                            <i class="fas fa-times"></i>
                            Clear filters
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-conten-between">
                    <div class="form-group form-check mx-2">
                        {!! Form::checkbox('has_company_profile', true, $request->hasCompanyProfile(), ['class' => 'form-check-input', 'id' => 'has_company_profile'])  !!}
                        <label class="form-check-label" for="has_company_profile">Only show partners with company profile</label>
                    </div>
                    <div class="form-group form-check mx-2">
                        {!! Form::checkbox('has_vacancies', true, $request->hasVacancies(), ['class' => 'form-check-input', 'id' => 'has_vacancies'])  !!}
                        <label class="form-check-label" for="has_vacancies">Only show partners with vacancies</label>
                    </div>
                    <div class="form-group form-check mx-2">
                        {!! Form::checkbox('has_footer', true, $request->hasFooter(), ['class' => 'form-check-input', 'id' => 'has_footer'])  !!}
                        <label class="form-check-label" for="has_footer">Only show partners with footer</label>
                    </div>
                    <div class="form-group form-check mx-2">
                        {!! Form::checkbox('show_archived', true, $request->showArchived(), ['class' => 'form-check-input', 'id' => 'show_archived'])  !!}
                        <label class="form-check-label" for="show_archived">Include archived partners</label>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th colspan="2">Partner</th>
                    <th>Sector / status</th>
                    <th>Company profile</th>
                    <th>Footer</th>
                    <th>Vacancies</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $partner)
                    <tr>
                        <td style="width: 200px;" class="align-middle">
                                <img
                                    class="rounded ml-2 my-2"
                                    src="{{ $partner->logo }}"
                                    alt="Logo of {{ $partner->name }}"
                                    style="width: 150px; max-width: 150px; max-height: 80px; object-fit: cover;"
                                />
                        </td>
                        <td>
                            <a href="{{ action(
                                        [\Francken\Extern\Http\AdminPartnersController::class, 'show'],
                                        ['partner' => $partner]
                                        ) }}"
                            >
                                <h4 class='d-flex flex-column h6'>
                                    <span>
                                        {{ $partner->name }}
                                    </span>
                                    @if ($partner->last_contract_ends_at)
                                    <small class="text-muted mt-1">
                                        <i class="fas fa-file-contract fa-fw"></i>
                                        Contract ends in
                                        {{ $partner->last_contract_ends_at->diffForHumans() }}
                                    </small>
                                    @endif
                                    <small class="text-muted mt-1">
                                        <i class="fas fa-clock fa-fw"></i>
                                        Last updated
                                        {{ $partner->updated_at->diffForHumans() }}
                                    </small>
                                </h4>
                        </a>
                    </td>
                    <td>
                        <div class="d-flex flex-column align-items-start justify-content-center">
                            <small class="text-muted">
                                {{ $partner->sector->name }}
                            </small>
                            <small class="text-muted mt-2">
                                {{ $partner->display_status }}
                            </small>
                        </div>
                    </td>
                    <td class="">
                        @if ($partner->companyProfile)
                            <p class="text-muted">
                                <i class="far fa-check-square"></i>
                                Last changed {{ $partner->companyProfile->updated_at->diffForHumans() }}
                            </p>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="">
                        @if ($partner->footer)
                            <p class="text-muted">
                                <i class="far fa-check-square"></i>
                                Last changed {{ $partner->footer->updated_at->diffForHumans() }}
                            </p>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="">
                        @if ($partner->vacancies_count > 0)
                            <i class="far fa-check-square"></i>
                            {{ $partner->vacancies_count }} vacancies
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-footer">
            {!! $partners->links() !!}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        <a href="{{ action([\Francken\Extern\Http\AdminPartnersController::class, 'create']) }}"
           class="btn btn-primary"
        >
            <i class="fas fa-plus"></i>
            Add a partner
        </a>
    </div>
@endsection
