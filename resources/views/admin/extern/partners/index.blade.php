@extends('admin.layout')
@section('page-title', 'Partners')

@section('content')
    <div class="card">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Partner</th>
                    <th>Company profile</th>
                    <th>Footer</th>
                    <th>Vacancies</th>
                    <th>TV</th>
                    <th>Streepsysteem</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $partner)
                <tr>
                    <td>
                        <a href="{{ action(
                                    [\Francken\Extern\Http\AdminPartnersController::class, 'show'],
                                    ['partner' => $partner]
                                    ) }}"
                        >
                            <div class="d-flex justify-content-start">
                                <div>
                                    <img
                                        class="rounded mr-3"
                                        src="{{ $partner->logo }}"
                                        alt="Logo of {{ $partner->name }}"
                                        style="width: 90px; height: 90px; object-fit: cover;"
                                    />
                                </div>
                                <h4 class='d-flex flex-column my-3 h5'>
                                    <span>
                                        {{ $partner->name }}
                                    </span>
                                    <small class="mt-2">
                                        Last updated
                                        {{ $partner->updated_at->diffForHumans() }}
                                    </small>
                                </h4>
                            </div>
                        </a>
                    </td>
                    <td class="align-middle">
                        @if ($partner->has_company_profile)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if ($partner->has_footer)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if ($partner->has_vacancies)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if ($partner->has_tv)
                            <i class="far fa-check-square"></i>
                        @else
                            <i class="far fa-square"></i>
                        @endif
                    </td>
                    <td class="align-middle">
                        @if ($partner->has_plus_one)
                            <i class="far fa-check-square"></i>
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

        {!! $partners->links() !!}
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
