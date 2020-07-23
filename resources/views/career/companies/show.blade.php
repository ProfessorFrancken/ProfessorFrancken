@extends('layout.two-column-layout')
@section('header-image-url', '/images/header/oslo.jpg')
@section('title', $partner->companyProfile->display_name . " - T.F.V. 'Professor Francken'")

@section('content')

    <h1 class="section-header">
        {{ $partner->companyProfile->display_name }}
    </h1>

    <div class="text-justify">
        {!! $partner->companyProfile->compiled_content !!}
    </div>

    @if (count($jobs) > 0)
        <h2 class="mb-3 mt-4">
            <i class="fa fa-suitcase" aria-hidden="true"></i>
            Job openings from {{ $partner->companyProfile->display_name }}
        </h2>

        <ul class="list-unstyled">
        @foreach ($jobs as $job)
            <li class="job-opening py-3">
                <a href="{{ $job['link'] }}" class="mb-0">
                    <h3 class="h5 job-opening__title mb-0">
                        {{ $job['job'] }}
                        <small class="text-muted h5 mb-0">
                            ({{ $job['type'] }})
                        </small>
                    </h3>
                </a>
            </li>
        @endforeach
        </ul>
    @endif
@endsection

@section('aside')
<div class="agenda">
        <table class="infobox vcard" style="width:22em">
            <tbody>
                <tr>
                    <img src="{{ $partner->logo }}" class="img-fluid" alt="{{ $partner->companyProfile->display_name }}'s logo"/>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="agenda mt-5">
        <h3 class="section-header agenda-header">
            Companies
        </h3>
        <ul class="agenda-list list-unstyled">
            @foreach ($partners as $partner)
                <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                    <a
                        href="{{ action([Francken\Extern\Http\CompaniesController::class, 'show'], ['partner' => $partner])}}"
                        class="aside-link"
                    >
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h5 class="agenda-item__header">
                                    {{ $partner->companyProfile->display_name }}
                                </h5>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
