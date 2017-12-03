@extends('layout.two-column-layout')
@section('header-image-url', '/images/header/oslo.jpg')
@section('title', $company['name'] . " - T.F.V. 'Professor Francken'")

@section('content')

    <h1 class="section-header">
        {{  $company['name']}}
    </h1>

    <div class="text-justify">
		    {!!  $company['summary'] !!}
    </div>

    @if (count($jobs) > 0)

        <h2 class="mb-3 mt-4">
            <i class="fa fa-suitcase" aria-hidden="true"></i>
            Job openings from {{ $company['name'] }}
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
					<img src="{{ $company['logo'] }}" class="img-fluid" alt="{{ $company['name'] }}'s logo"/>
				</tr>
			@foreach ($company['metadata'] as $metadata)
				<tr>
					<th>{{ $metadata['term'] }} </th>
					<td>{{ $metadata['description'] }} </td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
    <div class="agenda mt-5">
        <h3 class="section-header agenda-header">
            Companies
        </h3>
        <ul class="agenda-list list-unstyled">
            @foreach ($companies as $company)

                <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                    <a
                        href="/career/companies/{{ str_slug($company['name'])  }}"
                        class="aside-link"
                    >
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h5 class="agenda-item__header">
                                    {{ $company['name'] }}
                                </h5>
                            </div>

                        </div>
                    </a>

                </li>
            @endforeach
        </ul>
    </div>
@endsection
