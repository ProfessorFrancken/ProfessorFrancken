<div class="row">
  <div class="col-md-7">
    <h2 id="{{ $board['year'] }}">Board {{ $board['year'] }} ‘{{ $board['name'] }}’</h2>
    <ul>
      @foreach($board['members'] as $member)
        <li>{{ $member['name'] }} - {{ $member['title'] }}</li>
      @endforeach
    </ul>
  </div>
  <div class="col-md-5">
    <img width="100%" src="{{ $board['figure'] }}">
  </div>
</div>