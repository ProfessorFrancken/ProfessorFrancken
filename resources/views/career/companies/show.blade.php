@extends('homepage.two-column-layout')

@section('content')

    <div class="section-header d-inline-block mt-4 h1">
        {{  $company['name']}}
    </div>
	
    <div class="row mt-2">
			<div class="col text-justify " >

		        {!!  $company['summary'] !!}
			</div>
    </div>
    <br>
    <br><br><br>
@endsection

@section('aside')
<div class="agenda">
		<h3 class="section-header agenda-header">{{ $company['name'] }}</h3>
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
