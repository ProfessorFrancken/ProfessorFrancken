@extends('homepage.two-column-layout')

@section('content')

    <div class="text-center">
        <img class="img-fluid" alt="" src="{{ image($committee->logo(), ['height' => 500, 'width' => 500]) }}"/>
    </div>

    <h2 class="section-header">
        {{ $committee->name() }}
    </h2>


    @yield('committee-content')

    <hr/>

    @include('committees._members', ['members' => $committee->members() ])
@endsection

@section('aside')
    <div class="agenda">
        <h3 class="section-header agenda-header">
            Committees
        </h3>
        <ul class="agenda-list list-unstyled">
            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <div class="form-group">
                    <input type="text" class="form-control" id="search-committees" placeholder="Search committees">
                </div>

            </li>

            {{-- Mark the active committee with a highlighted background --}}
            <?php $id = $committee->id(); ?>

            @foreach ($committees as $committee)

                <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                    <a
                        href="/association/committees/{{ $committee->link() }}"
                        class="aside-link {{ $committee->id() == $id ? 'aside-link--active' : '' }}"
                    >
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h5 class="agenda-item__header">
                                    {{ $committee->name() }}
                                </h5>
                            </div>
                            @if (! is_null($committee->logo()))
                                <img
                                    class="rounded d-flex ml-3"
                                    src="{{ image($committee->logo(), ['height' => 75, 'width' => 75]) }}"
                                    alt="{{ $committee->name() }}'s logo"
                                    style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                            >
                            @endif
                        </div>
                    </a>

                </li>
            @endforeach

            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" checked>
                            Only show committees of current studyyear
                        </label>
                    </div>

                </div>

            </li>
        </ul>
    </div>
@endsection

@section('header-image')
    @component('homepage.header._header_image')
    <div class="header-image__title">

    </div>
    @endcomponent
@endsection
