<h1>{{  $group['title']}}</h1>
<div class="row">

	<div class="col text-justify">
		<br>
		{!!  $group['description'] !!}
	</div>
	<div class="col">
		<img src="http://www.rug.nl{{ $group['photo'] }}" width="450" height="225"> 
	</div>
</div>
<br>
<div class="row">
	@foreach($group['groups'] as $unit)
		<div class="col">
			<img src="http://www.rug.nl{{ $unit['foto'] }}" width="283" height="142"> 
			<h2>Prof. {{ $unit['group'] }}</h2>
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
