<div class="container my-5" style="">
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
            <img src="{{ $board->photo() }}" class="img-fluid rounded board-image"/>
        @endif
    </div>
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
                <img
                    class="board-member__photo mt-3"
                    src="{{ $member['photo'] or 'https://api.adorable.io/avatars/150/' .  str_slug($member['name']) . '.png' }}"
                    alt="Photo of {{ $member['name'] }}"
                >
            </li>
        @endforeach
    </ul>
</div>
