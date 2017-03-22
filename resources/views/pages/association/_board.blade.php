<div class="row">
  <div class="col-md-7">
    @if ($board['name'] != '')
	<h2 id="{{ $board['year'] }}">Board {{ $board['year'] }} ‘{{ $board['name'] }}’</h2>
    @else
	<h2 id="{{ $board['year'] }}">Board {{ $board['year'] }}</h2>
    @endif
    <ul>
      @foreach($board['members'] as $member)
        <li>{{ $member['name'] }} - {{ $member['title'] }}</li>
      @endforeach
    </ul>
  </div>
  <div class="col-md-5">
    @if ($board['figure'] != '')
        <img width="100%" src="{{ $board['figure'] }}" class="img-fluid rounded">
    @endif
  </div>
</div>

<hr/>
