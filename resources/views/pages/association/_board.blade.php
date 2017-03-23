<hr>

<div class="row">
    <div class="col-md-7">
        @if ($board['name'] != '')
	          <h4 id="{{ $board['year'] }}" class="text-muted">
                ‘{{ $board['name'] }}’
                <small>
                    {{ $board['year'] }}
                </small>
            </h4>
        @else
	          <h4 id="{{ $board['year'] }}">
                Board of {{ $board['year'] }}
            </h4>
        @endif
        <dl class="row">
            @foreach($board['members'] as $member)
                <dt class="col-sm-4 text-muted">{{ $member['name'] }}</dt>
                <dd class="col-sm-8 text-muted">{{ $member['title'] }}</dd>
            @endforeach
        </dl>
    </div>

    <div class="col-md-5">
        @if ($board['figure'] != '')
            <img
                src="{{ $board['figure'] }}"
                class="img-fluid rounded"
                style="width: 100%; height: 250px; object-fit: cover"
            >
        @endif
    </div>
</div>
