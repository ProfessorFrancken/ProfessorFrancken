@extends('layout.one-column-layout')
@section('header-image-url', '/images/header/oslo.jpg')
@section('title', "Company profiles - T.F.V. 'Professor Francken'")
@section('keywords', $keywords)

@section('content')
    <h1 class="section-header section-header--centered">Companies</h1>

    <div class="row">
        @foreach ($partners as $partner)
            <div class="col-sm-6 col-md-4">
                <div class="company-card">
                    <a
                        href="{{ action([Francken\Extern\Http\CompaniesController::class, 'show'], ['partner' => $partner])}}"
                        class="company-card__link"
                    >
                        @if ( $partner->logo !== null)
                            <img
                                alt="{{ $partner->companyProfile->display_name }}"
                                src="{{ $partner->logo }}"
                                class="company-card__logo"
                            />
                        @else
                            <h4 class="company-card__name">
                                {{ $partner->companyProfile->display_name }}
                            </h4>
                        @endif
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
