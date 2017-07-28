<div class="container my-4">
    <div class="board-container rounded {{($board->photo() != '') ? 'board-container--with-image' : ''}}">
	      <h3 class="section-header section-header--centered section-header--light board-header" >
            @if ($board->name() != '')
                ‘{{ $board->name() }}’
                <br/>
                <small>
                    {{ $board->startOfYear()->format('Y') }} - {{  $board->endOfYear()->format('Y') }}
                </small>
            @else
                {{ $board->startOfYear()->format('Y') }} - {{  $board->endOfYear()->format('Y') }}
            @endif
        </h3>
        @if ($board->photo() != '')
            <img
            src="{{ board_banner_image($board->photo(), ['vertical-offset' => $board->photoPosition]) }}"
            class="img-fluid rounded board-image"
            @if ($board->photoPosition() != '')
                style="object-position: 50% {{ $board->photoPosition }}%"
            @endif
            >
        @endif
    </div>

    @if ($board->photo() != '')
        <p class="text-right mt-3">
            <a class="text-muted" href="{{ $board->photo() }}">
                Download board photo
                <i class="fa fa-picture-o" aria-hidden="true"></i>
            </a>
        </p>
    @endif
</div>

<div class="container my-4">
    <ul class="list-unstyled row">
        @foreach($board->members() as $member)
            <li class="col board-member">
                <h4>
                    {{ $member['name'] }}
                </h4>
                <h6>
                    {{ $member['title'] }}
                </h6>

                @if (isset($member['photo']))
                <img
                    class="board-member__photo mt-3"
                    src="{{ image('http://professorfrancken.nl' . $member['photo'], ['width' => 150, 'height' => 150]) }}"
                    alt="Photo of {{ $member['name'] }}"
                >
                @endif
            </li>
        @endforeach
    </ul>
</div>
