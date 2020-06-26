@extends('admin.layout')
@section('page-title', 'Partners')

@section('content')
    <div class="card">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th colspan="2">Partner</th>
                    <th>Company profile</th>
                    <th>Footer</th>
                    <th>Vacancies</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $partner)
                    <tr>
                        <td style="width: 200px;">
                            <div style="">
                                <img
                                    class="rounded mr-3"
                                    src="{{ $partner->logo }}"
                                    alt="Logo of {{ $partner->name }}"
                                    style="width: 150px; max-width: 150px; max-height: 90px; object-fit: cover;"
                                />
                            </div>
                        </td>
                        <td>
                            <a href="{{ action(
                                        [\Francken\Extern\Http\AdminPartnersController::class, 'show'],
                                        ['partner' => $partner]
                                        ) }}"
                            >
                            <div class="d-flex justify-content-start">
                                <h4 class='d-flex flex-column my-3 h5'>
                                    <span>
                                        {{ $partner->name }}
                                    </span>
                                    <small class="text-muted mt-2">
                                        {{ $partner->display_status }}
                                    </small>
                                    <small class="text-muted mt-1">
                                        Last updated
                                        {{ $partner->updated_at->diffForHumans() }}
                                    </small>
                                </h4>
                            </div>
                        </a>
                    </td>
                    <td class="align-middle">
                        @if ($partner->companyProfile)
                            <p class="mt-3 mb-0 text-muted">
                                <i class="far fa-check-square"></i>
                                Last changed {{ $partner->companyProfile->updated_at->diffForHumans() }}
                            </p>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if ($partner->footer)
                            <p class="mt-3 mb-0 text-muted">
                                <i class="far fa-check-square"></i>
                                Last changed {{ $partner->footer->updated_at->diffForHumans() }}
                            </p>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if ($partner->vacancies_count > 0)
                            <i class="far fa-check-square"></i>
                            {{ $partner->vacancies_count }} vacancies
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="text-right align-middle">
                        <a
                           class="btn btn-text"
                            href="{{ action(
                                    [\Francken\Extern\Http\AdminPartnersController::class, 'show'],
                                    ['partner' => $partner]
                                     ) }}"
                        >
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Inspect
                        </a>
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
