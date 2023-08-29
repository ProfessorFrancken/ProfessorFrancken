@extends('layout.two-column-layout')

@section('content')

    <div class="text-center">
        <img class="img-fluid" alt="" src="{{ image($committee->logo, ['height' => 500, 'width' => 500]) }}"/>
    </div>

    <h2 class="section-header">
        {{ $committee->name }}
    </h2>


    @yield('committee-content')

    <hr/>

    @if (! is_null($committee->photo))
        <div class='d-flex justify-content-center my-3'>
        <img
            class="img-fluid"
            src="{{ image($committee->photo, ['height' => 400, 'width' => 660, 'resize' => true]) }}"
            alt="{{ $committee->name }}'s logo"
        >
        </div>
        <hr/>
    @endif

    @include('committees._members', ['members' => $committee->members ])
@endsection

@section('aside')
    <div class="agenda">
        <h3 class="section-header agenda-header">
            Committees
        </h3>
        <ul class="agenda-list list-unstyled">
            {{-- Mark the active committee with a highlighted background --}}
            <?php $id = $committee->id; ?>

            @foreach ($committees as $committee)

                <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                    <a
                        href="{{ action([\Francken\Association\Committees\Http\CommitteesController::class, 'show'], ['board' => $committee->board, 'committee' => $committee]) }}"
                        class="aside-link {{ $committee->id == $id ? 'aside-link--active' : '' }}"
                    >
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h5 class="agenda-item__header">
                                    {{ $committee->name }}
                                </h5>
                            </div>
                            @if (! is_null($committee->logo))
                                <img
                                    class="rounded d-flex ml-3"
                                    src="{{ image($committee->logo, ['height' => 75, 'width' => 75]) }}"
                                    alt="{{ $committee->name }}'s logo"
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

@section('header-image')
    @component('layout.header._header_image')
    <div class="header-image__title">

    </div>
    @endcomponent
@endsection
