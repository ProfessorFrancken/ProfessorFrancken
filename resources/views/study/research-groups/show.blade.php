@extends('layout.two-column-layout')
@section('title', $group['title'] . " - Research Groups - T.F.V. 'Professor Francken'")
@section('header-image-url', 'https://www.rug.nl' . $group['photo'])

@section('content')
    <div class="section-header d-inline-block mt-4 h1">
        {{  $group['title']}}
    </div>
    <div class="row mt-2">

	      <div class="col text-justify " >

		        {!!  $group['description'] !!}
	      </div>
    </div>
    <br>
    <div class="row">
	      @foreach($group['groups'] as $unit)
		        <div class="col-md-6 mt-3">
			          <img src="{{ image("https://www.rug.nl" . $unit['foto'], ['width' => 283, 'height' => 142]) }}" width="283" height="142" class="rounded">
                        <h2> {{ $unit['group'] }} Group</h2>
			          {{ $unit['title'] }}
			          <br>
			          <a class="btn btn-secondary" href="{{ $unit['contact'] }}">
				            Contact
			          </a>
			          <a class="btn btn-info" href="{{ $unit['link'] }}">
				            Group Info
			          </a>
		        </div>
	      @endforeach
    </div>
    <br><br><br>
@endsection

@section('aside')
    <div class="agenda">
        <h3 class="section-header agenda-header">
            Research groups
        </h3>
        <ul class="agenda-list list-unstyled">
            @foreach ($groups as $group)

                <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                    <a
                        href="/study/research-groups/{{ str_slug($group['title'])  }}"
                        class="aside-link"
                    >
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h5 class="agenda-item__header">
                                    {{ $group['title'] }}
                                </h5>
                            </div>

                            @if (isset($group['photo']))
                                <img
                                class="rounded d-flex ml-3"
                                    src="{{ image("https://www.rug.nl" . $group['photo'], ['width' => 75, 'height' => 75]) }}"
                                    alt="{{ $group['title'] }}'s logo"
                                    style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                                >
                            @endif
                        </div>
                    </a>

                </li>
            @endforeach
        </ul>
    </div>
@endsection
