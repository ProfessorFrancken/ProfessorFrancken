<div class="container my-4">
    <div class="board-container rounded {{($board->photo !== null) ? 'board-container--with-image' : ''}}">
          <h3 class="section-header section-header--centered section-header--light board-header" >
            @if ($board->name != '')
                ‘{{ $board->board_name->toString() }}’
                <br/>
                <small>
                    {{ $board->board_year->toString() }}
                </small>
            @else
                {{ $board->board_year->toString() }}
            @endif
        </h3>
        @if ($board->photo !== null)
            <img
            src="{{ board_banner_image($board->photo, ['vertical-offset' => $board->photo_position]) }}"
            class="img-fluid rounded board-image"
            >
        @endif
    </div>

    @if ($board->photo !== null)
        <p class="text-right mt-3">
            <a class="text-muted" href="{{ $board->photo }}">
                Download board photo
                <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
        </p>
    @endif
</div>

<div class="container my-4">
    <ul class="list-unstyled row">
        @foreach($board->members as $member)
            <li class="col-12 col-sm-6 col-md board-member">
                <h4>
                    {{ $member->name }}
                </h4>
                <h6>
                    {{ $member->title }}
                </h6>

                @if ($member->photo !== null)
                <img
                    class="board-member__photo mt-3"
                    src="{{ image($member->photo, ['width' => 150, 'height' => 150]) }}"
                    alt="Photo of {{ $member->name }}"
                >
                @endif
            </li>
        @endforeach
    </ul>
</div>
